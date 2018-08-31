<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('icon')->nullable();
            $table->integer('parent')->nullable()->default(0);
            $table->string('url')->nullable()->default('#');
            $table->string('classname')->nullable();
            $table->integer('order')->nullable();
            $table->enum('show_in', ['frontend', 'backend'])->default('backend');
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->integer('menu_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->timestamps();
            $table->primary(['menu_id', 'group_id']);
        });

        Schema::table('roles', function ($table) {
            $table->foreign('menu_id')
                    ->references('id')->on('menus')
                    ->onDelete('cascade');
            $table->foreign('group_id')
                    ->references('id')->on('groups')
                    ->onDelete('cascade');
        });

        Schema::table('users', function ($table) {
            $table->foreign('group_id')
                    ->references('id')->on('groups')
                    ->onDelete('cascade');
        });

        Schema::table('users', function ($table) {
            $table->foreign('village_id')
                    ->references('id')->on('villages')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function ($table) {
            $table->dropForeign(['menu_id']);
            $table->dropForeign(['group_id']);
        });
        Schema::table('users', function ($table) {
            $table->dropForeign(['group_id']);
            $table->dropForeign(['village_id']);
        });
        Schema::drop('roles');
        Schema::drop('groups');
        Schema::drop('menus');
    }
}
