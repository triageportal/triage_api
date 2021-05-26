<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrematureEjaculationResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premature_ejaculation_results', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id');
            $table->integer('category_id');
            $table->integer('question_id');
            $table->integer('response_id');
            $table->integer('created_by');
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
        Schema::dropIfExists('premature_ejaculation_results');
    }
}
