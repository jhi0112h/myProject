<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_processes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sign_id')->unsigned();
            $table->string('state');
            $table->string('name');
            $table->text('content');
            $table->string('file')->nullable();
            $table->timestamps();
            $table->foreign('sign_id')->references('id')->on('signs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_processes');
    }
}
