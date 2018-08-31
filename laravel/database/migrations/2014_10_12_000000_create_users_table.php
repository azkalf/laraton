<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('fullname');
            $table->enum('gender', ['m', 'f']);
            $table->string('email')->unique();
            $table->string('photo')->nullable();
            $table->string('poster')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('birthdate')->nullable();
            $table->bigInteger('village_id')->nullable()->unsigned();
            $table->integer('postcode')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('about')->nullable();
            $table->string('password');
            $table->integer('group_id')->unsigned();
            $table->string('skin')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
