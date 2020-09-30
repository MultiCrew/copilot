<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStandsToFplTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flight_plans', function (Blueprint $table) {
            $table->string('dep_stand')->nullable();
            $table->string('arr_stand')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flight_plans', function (Blueprint $table) {
            $table->dropColumn('dep_stand');
            $table->dropColumn('arr_stand');
        });
    }
}
