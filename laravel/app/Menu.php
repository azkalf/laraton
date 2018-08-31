<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Role;
use Auth;

class Menu extends Model
{
    protected $guarded = [
    	'id'
    ];

    public function childs() {
    	return $this->hasMany('App\Menu', 'parent', 'id');
    }

    public static function getMenus() {
    	$menu_lists = array();
		$top_menus = self::where('parent', 0)->oldest('order')->get();
		foreach ($top_menus as $key => $top) {
			$menu_lists[$key]['id'] = $top['id'];
			$menu_lists[$key]['title'] = $top['title'];
			$menu_lists[$key]['icon'] = $top['icon'];
			$menu_lists[$key]['classname'] = $top['classname'];
			$menu_lists[$key]['url'] = $top['url'];
			$menu_lists[$key]['items'] = self::getChildMenus($top['id']);
		}
		return $menu_lists;
    }

    public static function getChildMenus($menu_id) {
    	$menu_lists = array();
    	$menus = self::where('parent',$menu_id)->oldest('order')->get();
    	foreach ($menus as $key => $menu) {
			$menu_lists[$key]['id'] = $menu['id'];
			$menu_lists[$key]['title'] = $menu['title'];
			$menu_lists[$key]['icon'] = $menu['icon'];
			$menu_lists[$key]['class'] = $menu['classname'];
			$menu_lists[$key]['url'] = $menu['url'];
			$child = self::where('parent', $menu['id'])->get();
			if (count($child) > 0) {
				$menu_lists[$key]['items'] = self::getChildMenus($menu['id']);
			}
    	}
    	return $menu_lists;
    }

    public static function getRoledMenus() {
    	$menu_lists = array();
		$group_menus = Role::select('menu_id')->where('group_id', Auth::User()->group_id)->get();
		$menus = array();
		foreach ($group_menus as $menu) {
			$menus[] = $menu['menu_id'];
		}
		$top_menus = self::whereIn('id',$menus)->where('parent', 0)->oldest('order')->get();
		foreach ($top_menus as $key => $top) {
			$menu_lists[$key]['id'] = $top['id'];
			$menu_lists[$key]['title'] = $top['title'];
			$menu_lists[$key]['icon'] = $top['icon'];
			$menu_lists[$key]['class'] = $top['classname'];
			$menu_lists[$key]['url'] = $top['url'];
			$menu_lists[$key]['items'] = self::getChildRoledMenus($top['id'], $group_menus);
		}
		return $menu_lists;
    }

    public static function getChildRoledMenus($menu_id, $lists) {
    	$menu_lists = array();
    	$menus = self::where('parent',$menu_id)->whereIn('id', $lists)->oldest('order')->get();
    	foreach ($menus as $key => $menu) {
			$menu_lists[$key]['id'] = $menu['id'];
			$menu_lists[$key]['title'] = $menu['title'];
			$menu_lists[$key]['icon'] = $menu['icon'];
			$menu_lists[$key]['class'] = $menu['classname'];
			$menu_lists[$key]['url'] = $menu['url'];
			$child = self::where('parent', $menu['id'])->get();
			if (count($child) > 0) {
				$menu_lists[$key]['items'] = self::getChildMenus($menu['id'], $lists);
			}
    	}
    	return $menu_lists;
    }
}
