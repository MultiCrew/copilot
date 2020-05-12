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
            $table->json('departure')->nullable()->customSchemaOptions(['collation' => 'utf8mb4_unicode_ci', 'charset' => ''])->change();
            $table->json('arrival')->nullable()->customSchemaOptions(['collation' => 'utf8mb4_unicode_ci', 'charset' => ''])->change();
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
            $table->string('departure')->change();
            $table->string('arrival')->change();
        });
    }
}
