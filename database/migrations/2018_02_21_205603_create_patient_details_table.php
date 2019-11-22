<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id');
            $table->integer('doctor_id')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('city',255)->nullable();
            $table->string('phone_number', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
            /*foreign keys*/
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('doctor_id')->references('id')->on('doctors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_details');
    }
}
