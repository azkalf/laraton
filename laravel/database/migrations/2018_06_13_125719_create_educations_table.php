<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->enum('level', ['tk', 'sd', 'smp', 'sma', 'd1', 'd2', 'd3', 'd4', 's1', 's2', 's3']);
            $table->string('name');
            $table->string('majors')->nullable();
            $table->string('place');
            $table->integer('year_in');
            $table->integer('year_out')->nullable();
            $table->enum('current', ['yes', 'no']);
            $table->timestamps();
        });

        Schema::table('educations', function ($table) {
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
        Schema::table('educations', function ($table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('educations');
    }
}
