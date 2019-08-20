<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\Group;
use App\Role;
use App\User;
use App\Setting;
use Hash;
use Image;
use Auth;

class ConfigurationController extends Controller
{
    public function __construct(Request $request)
    {
    	$this->middleware('auth');
        $this->middleware(function ($request, $next) {
        	$uri = $request->segment(1);
	        if (!roled($uri)) {
				abort(403);
	        }
            return $next($request);
        });
    }

    public function menu()
    {
        $menus = Menu::getMenus();
        return view('config.menu', compact('menus'));
    }

    public function sort_menu(Request $request)
    {
        $menus = json_decode($request->menus);
        $order = 0;
        foreach ($menus as $list) {
            $menu = Menu::find($list->id);
            $menu->order = $order;
            $menu->parent = 0;
            $menu->save();
            $order++;
            sort_menu($list);
        }
        echo 'Urutan Menu berhasil di update!';
    }

    public function update_menu(Request $request)
    {
        $menu = Menu::find($request->id);
        $menu->title = $request->title;
        $menu->icon = $request->icon;
        $menu->url = $request->url;
        if ($menu->save()) {
            echo 'Menu berhasil diupdate!';
        } else {
            echo 'Menu gagal diupdate!';
        }
    }

    public function add_menu(Request $request)
    {
        $menu = new Menu;
        $menu->title = $request->title;
        $menu->icon = $request->icon;
        $menu->url = $request->url;
        $menu->parent = 0;
        $order = Menu::where('parent', 0)->max('order');
        $menu->order = $order + 1;
        if ($menu->save()) {
            $data['id'] = $menu->id;
            $data['title'] = $menu->title;
            $data['message'] = 'Menu berhasil disimpan!';
            echo json_encode($data);
        } else {
            echo 'Menu gagal disimpan!';
        }
    }

    public function delete_menu(Request $request)
    {
        if (protected_menu($request->id)) {
            $data['status'] = 'failed';
            $data['message'] = 'Menu ini nggak boleh dihapus!';
        } else {
            $menus = Menu::where('parent', $request->id)->get();
            if ($menus) {
                foreach ($menus as $menu) {
                    $menu->parent = 0;
                    $menu->save();
                }
            }
            $menu = Menu::find($request->id);
            if ($menu->delete()) {
                $data['status'] = 'success';
                $data['message'] = 'Menu '.$menu->title.' berhasil dihapus!';
            } else {
                $data['status'] = 'failed';
                $data['message'] = 'Menu gagal dihapus!';
            }
        }
        echo json_encode($data);
    }

    public function group()
    {
        $menus = Menu::getMenus();
        $groups = Group::all();
        return view('config.group', compact('groups', 'menus'));
    }

    public function fill_menu(Request $request)
    {
        $menus = Role::select('menu_id')->where('group_id', $request->id)->get();
        $data = [];
        foreach ($menus as $menu) {
            $data[] = $menu->menu_id;
        }
        echo json_encode($data);
    }

    public function update_menu_group(Request $request)
    {
        $data = [];
        $key = 0;
        $menus = is_array($request->menus) ? $request->menus : [];
        if ($request->id == 1) {
            $group_menus = Role::where('group_id', $request->id)->get();
            foreach ($group_menus as $menu) {
                if (!in_array($menu->menu_id, $menus)) {
                    if (protected_menu($menu->menu_id)) {
                        $menu_title = Menu::find($menu->menu_id)->title;
                        $data['info'][$key]['status'] = 'failed';
                        $data['info'][$key]['message'] = 'Menu '.$menu_title.' untuk Super Administrator nggak boleh di apa apain!';
                        $key++;
                    } else {
                        Role::where('group_id', $request->id)->where('menu_id', $menu->menu_id)->delete();
                    }
                }
            }
        } else {
            Role::where('group_id', $request->id)->delete();
        }
        if (isset($menus)) {
            foreach ($menus as $menu) {
                $role = Role::where('group_id', $request->id)->where('menu_id', $menu)->first();
                if (!$role) {
                    $role = new Role;
                    $role->group_id = $request->id;
                    $role->menu_id = $menu;
                    $role->save();
                    $parent = Menu::find($menu)->parent;
                    if ($parent > 0) {
                        $role_check = Role::where('menu_id', $parent)->where('group_id', $request->id)->first();
                        if (empty($role_check->menu_id)) {
                            $new_role = new Role;
                            $new_role->group_id = $request->id;
                            $new_role->menu_id = $parent;
                            $new_role->save();
                        }
                    }
                }
            }
        }
        $menus = Role::select('menu_id')->where('group_id', $request->id)->get();
        foreach ($menus as $menu) {
            $data['menus'][] = $menu->menu_id;
        }
        $data['message'] = 'Hak Akses Menu berhasil disimpan!';
        echo json_encode($data);
    }

    public function edit_group(Request $request)
    {
        if (protected_group($request->id)) {
            $group = Group::find($request->id);
            $data['status'] = 'failed';
            $data['message'] = 'Grup '.$group->name.' nggak boleh diedit!';
        } else {
            $group = Group::find($request->id);
            $group->name = $request->name;
            if ($group->save()) {
                $data['status'] = 'success';
                $data['message'] = 'Grup '.$group->name.' berhasil diedit!';
            } else {
                $data['status'] = 'failed';
                $data['message'] = 'Grup '.$group->name.' gagal diedit!';
            }
        }
        echo json_encode($data);
    }

    public function add_group(Request $request)
    {
        $group = new Group;
        $group->name = $request->name;
        if ($group->save()) {
            $data['status'] = 'success';
            $data['message'] = 'Grup '.$group->name.' berhasil dibuat!';
            $data['name'] = $group->name;
            $data['id'] = $group->id;
        } else {
            $data['status'] = 'failed';
            $data['message'] = 'Grup '.$group->name.' gagal dibuat!';
        }
        echo json_encode($data);
    }

    public function delete_group(Request $request)
    {
        if (protected_group($request->id)) {
            $group = Group::find($request->id);
            $data['status'] = 'failed';
            $data['message'] = 'Grup '.$group->name.' nggak boleh dihapus!';
        } else {
            $group = Group::find($request->id);
            if ($group->delete()) {
                $data['status'] = 'success';
                $data['message'] = 'Grup '.$group->name.' berhasil dihapus!';
            } else {
                $data['status'] = 'failed';
                $data['message'] = 'Grup '.$group->name.' gagal dihapus!';
            }
        }
        echo json_encode($data);
    }

    public function user()
    {
        $users = User::whereHas('group', function($query) {
            $query->where('id', '>', 1);
        })->get();
        return view('config.user', compact('users'));
    }

    public function get_user(Request $request)
    {
        $user = User::find($request->id);
        $user->birthdate = !empty($user->birthdate) ? fdate($user->birthdate) : '';
        echo json_encode($user);
    }

    public function create_user(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->group_id = $request->group_id;
        $user->password = Hash::make($request->password);
        $user->save();
        session()->flash('success', 'Data Anggota berhasil ditambahkan.');
        return redirect('user');
    }

    public function delete_user(Request $request)
    {
        if (protected_user($request->id)) {
            $user = User::find($request->id);
            $data['status'] = 'failed';
            $data['message'] = 'User '.$user->fullname.' nggak boleh dihapus!';
        } else {
            $user = User::find($request->id);
            if ($user->delete()) {
                $data['status'] = 'success';
                $data['message'] = 'User '.$user->fullname.' berhasil dihapus!';
            } else {
                $data['status'] = 'failed';
                $data['message'] = 'User '.$user->fullname.' gagal dihapus!';
            }
        }
        echo json_encode($data);
    }

    public function setting()
    {
        $setting = Setting::first();
        return view('config.setting', compact('setting'));
    }

    public function update_setting(Request $request)
    {
        $setting = Setting::first();
        $setting->appname = $request->appname;
        $setting->subname = $request->subname;
        $setting->copyright = $request->copyright;
        $setting->version = $request->version;
        $setting->skin = $request->skin;
        if ($setting->save()) {
            echo 'Data Setting berhasil diedit!';
        } else {
            echo 'Data Setting gagal diedit!';
        }
    }

    public function update_logo(Request $request)
    {
        $setting = Setting::first();
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $destination = public_path().'/uploads/images/';
            $filename = 'logo_aplikasi.'.$logo->getClientOriginalExtension();
            if ($logo->isValid()) {
                if ($setting->logo != 'mtk_white.png' && !empty($setting->logo)) {
                    if (file_exists($destination.$setting->logo)) {
                        unlink($destination.$setting->logo);
                    }
                    if (file_exists($destination.'fit_'.$setting->logo)) {
                        unlink($destination.'fit_'.$setting->logo);
                    }
                }
                $logo->move($destination, $filename);
                // open file a image resource
                $img = Image::make($destination.$filename);
                // crop image
                $img->resize(null, 40, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destination.'fit_'.$filename);
                if ($img->width() > $img->height()) {
                    $img->resize(40, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                // crop fav_image
                $img->resizeCanvas(40, 40, 'center')->save($destination.'fav_'.$filename);
                $setting->logo = $filename;
                if($setting->save()) {
                    $data['logo'] = $filename;
                    $data['message'] = 'Logo berhasil diedit!';
                } else {
                    $data['message'] = 'Logo gagal diedit!';
                }
            } else {
                $data['message'] = 'Logo gagal di upload';
            }
        }
        echo json_encode($data);
    }

    public function reset_logo()
    {
        $setting = Setting::first();
        $oldlogo = $setting->logo;
        $setting->logo = 'mtk_white.png';
        if ($setting->save()) {
            if ($setting->logo != 'mtk_white.png' && !empty($setting->logo)) {
                $destination = public_path().'/uploads/images/';
                if (file_exists($destination.$oldlogo)) {
                    unlink($destination.$oldlogo);
                }
                if (file_exists($destination.'fit_'.$oldlogo)) {
                    unlink($destination.'fit_'.$oldlogo);
                }
            }
            echo 'Logo berhasil direset!';
        } else {
            echo 'Logo gagal direset!';
        }
    }

    public function update_poster(Request $request)
    {
        $setting = Setting::first();
        if ($request->hasFile('poster')) {
            $poster = $request->file('poster');
            $destination = public_path().'/uploads/images/posters/';
            $filename = 'poster_aplikasi.'.$poster->getClientOriginalExtension();
            if ($poster->isValid()) {
                if ($setting->poster != 'poster.jpg' && !empty($setting->poster)) {
                    if (file_exists($destination.$setting->poster)) {
                        unlink($destination.$setting->poster);
                    }
                    if (file_exists($destination.'fit_'.$setting->poster)) {
                        unlink($destination.'fit_'.$setting->poster);
                    }
                }
                $poster->move($destination, $filename);
                // open file a image resource
                $img = Image::make($destination.$filename);

                // crop image
                $img->fit(300, 135, function ($constraint) {
                    $constraint->upsize();
                }, 'top')->save($destination.'fit_'.$filename);
                $setting->poster = $filename;
                if($setting->save()) {
                    $data['poster'] = $filename;
                    $data['message'] = 'Poster berhasil diedit!';
                } else {
                    $data['message'] = 'Poster gagal diedit!';
                }
            } else {
                $data['message'] = 'Poster gagal di upload';
            }
        }
        echo json_encode($data);
    }

    public function reset_poster()
    {
        $setting = Setting::first();
        $oldposter = $setting->poster;
        $setting->poster = 'poster.jpg';
        if (is_null(Auth::User()->poster)) {
            $poster = 'poster.jpg';
        } else {
            $poster = Auth::User()->poster;
        }
        if ($setting->save()) {
            if ($setting->poster != 'poster.jpg' && !empty($setting->poster)) {
                $destination = public_path().'/uploads/images/posters/';
                if (file_exists($destination.$oldposter)) {
                    unlink($destination.$oldposter);
                }
                if (file_exists($destination.'fit_'.$oldposter)) {
                    unlink($destination.'fit_'.$oldposter);
                }
            }
            $data['message'] = 'Poster berhasil direset!';
            $data['poster'] = $poster;
        } else {
            $data['message'] = 'Poster gagal direset!';
        }
        echo json_encode($data);
    }

    public function update_bg(Request $request)
    {
        $setting = Setting::first();
        if ($request->hasFile('bg')) {
            $bg = $request->file('bg');
            $destination = public_path().'/uploads/images/';
            $filename = 'bg_aplikasi.'.$bg->getClientOriginalExtension();
            if ($bg->isValid()) {
                if ($setting->bg != 'bg.jpg' && !empty($setting->bg)) {
                    if (file_exists($destination.$setting->bg)) {
                        unlink($destination.$setting->bg);
                    }
                    if (file_exists($destination.'fit_'.$setting->bg)) {
                        unlink($destination.'fit_'.$setting->bg);
                    }
                }
                $bg->move($destination, $filename);
                // open file a image resource
                $img = Image::make($destination.$filename);
                $setting->bg = $filename;
                if($setting->save()) {
                    $data['bg'] = $filename;
                    $data['message'] = 'Bg berhasil diedit!';
                } else {
                    $data['message'] = 'Bg gagal diedit!';
                }
            } else {
                $data['message'] = 'Bg gagal di upload';
            }
        }
        echo json_encode($data);
    }

    public function reset_bg()
    {
        $setting = Setting::first();
        $oldbg = $setting->bg;
        $setting->bg = 'bg.jpg';
        if ($setting->save()) {
            if ($setting->bg != 'bg.jpg' && !empty($setting->bg)) {
                $destination = public_path().'/uploads/images/';
                if (file_exists($destination.$oldbg)) {
                    unlink($destination.$oldbg);
                }
                if (file_exists($destination.'fit_'.$oldbg)) {
                    unlink($destination.'fit_'.$oldbg);
                }
            }
            echo 'Bg berhasil direset!';
        } else {
            echo 'Bg gagal direset!';
        }
    }
}
