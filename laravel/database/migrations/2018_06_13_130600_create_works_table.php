<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('position')->nullable();
            $table->string('office')->nullable();
            $table->string('place');
            $table->integer('year_in');
            $table->integer('year_out')->nullable();
            $table->enum('current', ['yes', 'no']);
            $table->timestamps();
        });

        Schema::table('works', function ($table) {
            $table->foreign('user_id')
                    ->references('id')->on('users')
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
        Schema::table('works', function ($table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('works');
    }
}
