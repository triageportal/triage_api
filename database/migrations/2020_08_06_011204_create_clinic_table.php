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
            $table->String('name', 100);
            $table->String('status', 50);
            $table->String('addressLineOne', 255);
            $table->String('addressLineTwo', 255)->nullable();
            $table->String('city', 50);
            $table->String('zipCode', 15);
            $table->String('stateOrRegion', 50);
            $table->String('country', 50);
            $table->String('phone', 50);
            $table->String('clinicEmail', 100);
            $table->String('website', 255);
            $table->String('language', 50);
            $table->String('contactName', 100);
            $table->String('contactEmail', 100);
            $table->String('contactPhone', 50);
            $table ->Integer('created_by')->nullable();

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
