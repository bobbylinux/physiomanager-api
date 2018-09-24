<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('plan_id');
            $table->integer('therapy_id');
            $table->integer('physiotherapist_id');
            $table->decimal('price', 8, 2);
            $table->integer('units')->default(1);
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
            /*foreign keys*/
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->foreign('therapy_id')->references('id')->on('therapies');
            $table->foreign('physiotherapist_id')->references('id')->on('physiotherapists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
