<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertPrimaryDatas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('groups')->insert([
            ['id' => 1, 'name' => 'Super Administrator'],
            ['id' => 2, 'name' => 'Administrator'],
            ['id' => 3, 'name' => 'User'],
        ]);
        
        DB::table('users')->insert([
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
            ],
        ]);

        DB::table('menus')->insert([
            ['id'=>1, 'title'=>'CONFIGURATION', 'icon'=>'settings', 'parent'=>0, 'url'=>'#', 'order'=>0],
            ['id'=>2, 'title'=>'Menu', 'icon'=>'menu', 'parent'=>1, 'url'=>'menu', 'order'=>1],
            ['id'=>3, 'title'=>'Group', 'icon'=>'group', 'parent'=>1, 'url'=>'group', 'order'=>2],
            ['id'=>4, 'title'=>'User', 'icon'=>'person', 'parent'=>1, 'url'=>'user', 'order'=>3],
            ['id'=>5, 'title'=>'Setting', 'icon'=>'settings', 'parent'=>1, 'url'=>'setting', 'order'=>4],
        ]);

        DB::table('roles')->insert([
            ['menu_id'=>1, 'group_id'=>1],
            ['menu_id'=>2, 'group_id'=>1],
            ['menu_id'=>3, 'group_id'=>1],
            ['menu_id'=>4, 'group_id'=>1],
            ['menu_id'=>5, 'group_id'=>1],
            ['menu_id'=>1, 'group_id'=>2],
            ['menu_id'=>5, 'group_id'=>2],
        ]);

        DB::table('settings')->insert([
            'appname' => 'LARATON - ADMINBSB',
            'subname' => 'Laravel Skeleton with Admin BootStrap Base Material Design',
            'skin' => 'blue',
            'copyright' => '&copy; 2018 <a href="javascript:void(0);">Laraton - AdminBSB</a>.',
            'version' => '<b>Version: </b>1.0',
            'poster' => 'poster.jpg',
            'logo' => 'mtk_white.png',
            'bg' => 'bg.jpg',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
