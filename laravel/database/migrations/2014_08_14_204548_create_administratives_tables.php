<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministrativesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('regencies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('province_id')->unsigned();
            $table->string('name');
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('regency_id')->unsigned();
            $table->string('name');
        });

        Schema::create('villages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('district_id')->unsigned();
            $table->string('name');
        });

        Schema::table('regencies', function ($table) {
            $table->foreign('province_id')
                    ->references('id')->on('provinces')
                    ->onDelete('cascade');
        });

        Schema::table('districts', function ($table) {
            $table->foreign('regency_id')
                    ->references('id')->on('regencies')
                    ->onDelete('cascade');
        });

        Schema::table('villages', function ($table) {
            $table->foreign('district_id')
                    ->references('id')->on('districts')
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
        Schema::table('villages', function ($table) {
            $table->dropForeign(['district_id']);
        });
        Schema::table('districts', function ($table) {
            $table->dropForeign(['regency_id']);
        });
        Schema::table('regencies', function ($table) {
            $table->dropForeign(['regency_id']);
        });
        Schema::dropIfExists('villages');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('regencies');
        Schema::dropIfExists('provinces');
    }
}