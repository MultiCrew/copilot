<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->boolean('show_name')->default(0);
            $table->string('picture')->nullable();
            $table->string('location')->nullable();
            $table->json('sims')->nullable();
            $table->json('weather')->nullable();
            $table->boolean('airac')->nullable();
            $table->string('level')->nullable();
            $table->string('connection')->nullable();
            $table->string('procedures')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['picture', 'sims', 'weather', 'airac', 'level', 'connection', 'procedures']);
        });
    }
}
