<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id');
            $table->longText('pathological_conditions')->nullable();
            $table->longText('note')->nullable();
            $table->longText('program')->nullable();
            $table->longText('final_report')->nullable();
            $table->boolean('privacy')->nullable();
            $table->boolean('medical_certificate')->nullable();
            $table->integer('work_result_id')->nullable();
            $table->integer('pain_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            /*foreign keys*/
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('work_result_id')->references('id')->on('work_results');
            $table->foreign('pain_id')->references('id')->on('pains');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
