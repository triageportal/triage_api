<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTriagesDescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('triages_description', function (Blueprint $table) {
            $table->id();
            $table->integer('triage_id');
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
        Schema::dropIfExists('triages_description');
    }
}
