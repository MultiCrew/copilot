<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFlightRequestsTableAircraftColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flight_requests', function (Blueprint $table) {
            $table->dropColumn('aircraft');
            $table->unsignedBigInteger('aircraft_id');
            $table->foreign('aircraft_id')->references('id')->on('approved_aircraft');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flight_requests', function (Blueprint $table) {
            $table->dropColumn('aircraft_id');
            $table->string('aircraft');
        });
    }
}
