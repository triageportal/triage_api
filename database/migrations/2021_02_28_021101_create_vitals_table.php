<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vitals', function (Blueprint $table) {
            $table->id();            
            $table->integer('patient_id');
            $table->integer('entered_by');          
            $table->double('height_cm')->nullable();
            $table->double('weight_kg')->nullable();
            $table->double('calculated_bmi')->nullable();
            $table->double('temperature_c')->nullable();
            $table->integer('pulse')->nullable();
            $table->integer('respiratory_rate')->nullable();
            $table->integer('bp_systolic')->nullable();
            $table->integer('bp_diastolic')->nullable();
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
