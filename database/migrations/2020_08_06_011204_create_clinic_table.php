<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {

            $table->id();
            $table->timestamps();
            $table->string('name', 100);
            $table->string('status', 50);
            $table->string('addressLineOne', 255);
            $table->string('addressLineTwo', 255)->nullable();
            $table->string('city', 50);
            $table->string('zipCode', 15);
            $table->string('stateOrRegion', 50);
            $table->string('country', 50);
            $table->string('phone', 50);
            $table->string('clinicEmail', 150);
            $table->string('website', 255);
            $table->string('language', 50);
            $table->string('contactName', 100);
            $table->string('contactEmail', 150);
            $table->string('contactPhone', 50);
            $table ->integer('created_by')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic');
    }
}
