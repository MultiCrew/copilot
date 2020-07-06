<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDepartureAndArrivalColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flight_requests', function (Blueprint $table) {
            DB::statement('ALTER TABLE `flight_requests` ADD `departure_json` JSON');
            DB::statement('ALTER TABLE `flight_requests` ADD `arrival_json` JSON');
            DB::statement('UPDATE `flight_requests` SET `departure_json` = `departure`, `arrival_json` = `arrival`');
            DB::statement('ALTER TABLE `flight_requests` DROP COLUMN `departure`');
            DB::statement('ALTER TABLE `flight_requests` DROP COLUMN `arrival`');
            DB::statement('ALTER TABLE `flight_requests` CHANGE `departure_json` `departure` JSON');
            DB::statement('ALTER TABLE `flight_requests` CHANGE `arrival_json` `arrival` JSON');
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
            $table->rename('departure', 'departure_json');
            $table->rename('arrival', 'arrival_json');
            $table->string('departure');
            $table->string('arrival');
            DB::statement('UPDATE flight_requests SET departure = departure_json, arrival = arrival_json');
            $table->dropColumn('departure_json');
            $table->dropColumn('arrival_json');
        });
    }
}
