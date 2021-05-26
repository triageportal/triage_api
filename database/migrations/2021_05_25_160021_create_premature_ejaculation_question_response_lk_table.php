<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrematureEjaculationQuestionResponseLkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premature_ejaculation_quest_resp_lk', function (Blueprint $table) {
            $table->id();
            $table->integer('question_id');
            $table->integer('response_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('premature_ejaculation_question_response_lk');
    }
}
