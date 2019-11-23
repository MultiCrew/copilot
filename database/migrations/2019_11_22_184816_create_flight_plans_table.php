<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plan_url');
            $table->unsignedInteger('planner');
            $table->unsignedInteger('accepted_by_1');
            $table->unsignedInteger('accepted_by_2');
            $table->foreign('planner')->references('id')->on('users');
            $table->foreign('accepted_by_1')->references('id')->on('users');
            $table->foreign('accepted_by_2')->references('id')->on('users');
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
        Schema::dropIfExists('flight_plans');
    }
}
