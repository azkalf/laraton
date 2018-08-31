<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [
    	'id'
    ];

    public function users() {
        return $this->hasMany('App\User');
    }

    public static function groupList() {
    	$groups = self::where('id', '<>', Auth::User()->group_id)->latest('id')->get();
    	$list = array();
    	foreach ($groups as $group) {
    		$list[$group->id] = $group->name;
    	}
    	return $list;
    }
}
