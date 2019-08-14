<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\User;
use App\Group;
use App\Menu;
use App\Role;
use App\Setting;

class FrontController extends Controller
{
    public function reset_database()
    {
        Schema::disableForeignKeyConstraints();
        Setting::truncate();
        echo "settings truncated\n";
        User::truncate();
        echo "users truncated\n";
        Role::truncate();
        echo "roles truncated\n";
        Menu::truncate();
        echo "menus truncated\n";
        Group::truncate();
        echo "groups truncated\n";
        Schema::enableForeignKeyConstraints();

        Setting::insert([
            'appname' => 'LARATON - ADMINBSB',
            'subname' => 'Laravel Skeleton with Admin BootStrap Base Material Design',
            'skin' => 'blue',
            'copyright' => '&copy; 2018 <a href="javascript:void(0);">Laraton - AdminBSB</a>.',
            'version' => '<b>Version: </b>1.0',
            'poster' => 'poster.jpg',
            'logo' => 'mtk_white.png',
            'bg' => 'bg.jpg'
        ]);
        echo "settings created\n";

        $groups = [
            ['id' => 1, 'name' => 'Super Administrator'],
            ['id' => 2, 'name' => 'Administrator'],
            ['id' => 3, 'name' => 'User']
        ];

        $users = [
            [
                'id' => 1,
                'name' => 'superadmin',
                'fullname' => 'Super Admin',
                'email' => 'superadmin@server.com',
                'gender' => 'm',
                'group_id' => 1,
                'password' => bcrypt('rahasiasuper')
            ],
            [
                'id' => 2,
                'name' => 'admin',
                'fullname' => 'Admin',
                'email' => 'admin@server.com',
                'gender' => 'm',
                'group_id' => 2,
                'password' => bcrypt('rahasiaadmin')
            ],
            [
                'id' => 3,
                'name' => 'user_male',
                'fullname' => 'I\'m Male',
                'email' => 'imale@server.com',
                'gender' => 'm',
                'group_id' => 3,
                'password' => bcrypt('rahasiamale')
            ],
            [
                'id' => 4,
                'name' => 'user_female',
                'fullname' => 'I\'m Female',
                'email' => 'ifemale@server.com',
                'gender' => 'f',
                'group_id' => 3,
                'password' => bcrypt('rahasiafemale')
            ]
        ];

        $menus = [
            ['id'=>1, 'title'=>'KONFIGURASI', 'icon'=>'settings', 'parent'=>0, 'url'=>'#', 'order'=>0],
            ['id'=>2, 'title'=>'Menu', 'icon'=>'menu', 'parent'=>1, 'url'=>'menu', 'order'=>1],
            ['id'=>3, 'title'=>'Grup', 'icon'=>'group', 'parent'=>1, 'url'=>'group', 'order'=>2],
            ['id'=>4, 'title'=>'User', 'icon'=>'person', 'parent'=>1, 'url'=>'user', 'order'=>3],
            ['id'=>5, 'title'=>'Setting', 'icon'=>'settings', 'parent'=>1, 'url'=>'setting', 'order'=>4]
        ];

        $roles = [
            ['menu_id'=>1, 'group_id'=>1],
            ['menu_id'=>2, 'group_id'=>1],
            ['menu_id'=>3, 'group_id'=>1],
            ['menu_id'=>4, 'group_id'=>1],
            ['menu_id'=>5, 'group_id'=>1],
            ['menu_id'=>1, 'group_id'=>2],
            ['menu_id'=>5, 'group_id'=>2]
        ];

        Group::insert($groups);
        echo "groups created\n";

        User::insert($users);
        echo "users created\n";

        Menu::insert($menus);
        echo "menus created\n";

        Role::insert($roles);
        echo "roles created\n";
    }
}
