<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivedFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archived_flights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('requestee_id');
            $table->unsignedInteger('acceptee_id');
            $table->foreign('requestee_id')->references('id')->on('users');
            $table->foreign('acceptee_id')->references('id')->on('users');
            $table->string('departure');
            $table->string('arrival');
            $table->string('aircraft');
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
        Schema::dropIfExists('archived_flights');
    }
}
