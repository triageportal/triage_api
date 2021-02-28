<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBmiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bmi', function (Blueprint $table) {
            $table->id();            
            $table->integer('patient_id');
            $table->integer('entered_by');
            $table->integer('edited_by')->nullable();
            $table->double('height_cm');
            $table->double('weight_kg');
            $table->double('calculated_bmi');
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
        Schema::dropIfExists('bmi');
    }
}
