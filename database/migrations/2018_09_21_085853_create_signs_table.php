<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSignsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mb_id')->unsigned();
            $table->string('company');
            $table->integer('pay')->unsigned();
            $table->string('day');
            $table->integer('period')->unsigned(2);
            $table->string('keyword');
            $table->string('service');
            $table->string('phone', 14);
            $table->string('email');
            $table->text('comment')->nullable();
            $table->string('file')->nullable();
            $table->string('progress')->nullable();
            $table->string('receipt')->nullable();
            $table->string('homepage_url')->nullable();
            $table->timestamps();
            $table->foreign('mb_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('signs');
    }
}
