<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->json('new_request')->nullable();
            $table->boolean('request_accepted')->default(1);
            $table->boolean('request_accepted_email')->default(0);
            $table->boolean('request_accepted_push')->default(0);
            $table->boolean('plan_reviewed')->default(1);
            $table->boolean('plan_reviewed_email')->default(0);
            $table->boolean('plan_reviewed_push')->default(0);
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
        Schema::dropIfExists('user_notifications');
    }
}
