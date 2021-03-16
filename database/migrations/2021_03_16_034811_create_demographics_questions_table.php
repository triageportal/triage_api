<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemographicsQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demographics_questions', function (Blueprint $table) {
            $table->integer('id')->unique()->nullable();
            $table->integer('category_id')->nullable();
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
        Schema::dropIfExists('demographics_questions');
    }
}
