<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemographicsResponseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demographics_response', function (Blueprint $table) {
            $table->integer('id')->unique()->nullable();
            $table->integer('value')->nullable();
            $table->string('eng')->nullable();
            $table->string('rus')->nullable();
            $table->string('uzb')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demographics_response');
    }
}
