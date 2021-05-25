<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskFactorCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_factor_category', function (Blueprint $table) {
            $table->integer('id')->unique()->nullable();
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
        Schema::dropIfExists('risk_factor_category');
    }
}
