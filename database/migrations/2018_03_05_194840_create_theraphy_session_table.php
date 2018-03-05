<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTheraphySessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('therapy_session', function (Blueprint $table) {
            $table->integer('session_id');
            $table->integer('therapy_id');
            $table->decimal('price', 8, 2);
            $table->timestamps();
            $table->softDeletes();
            /*primary key*/
            $table->primary(array('session_id', 'therapy_id'));
            /*foreign key*/
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('therapy_id')->references('id')->on('therapies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('therapy_session');
    }
}
