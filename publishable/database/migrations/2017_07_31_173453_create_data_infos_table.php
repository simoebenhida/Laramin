<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('data_types_id')->unsigned();
            $table->foreign('data_types_id')->references('id')->on('data_types')->onDelete('cascade');
            $table->string('column');
            $table->string('type');
            $table->json('validation')->nullable();
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
        Schema::dropIfExists('data_infos');
    }
}
