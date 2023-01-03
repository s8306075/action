<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('status')->comment('1: resolved, 0: rejected, 2: processing, 3: pending');
            $table->string('name');
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->unsignedSmallInteger('score');
            $table->timestamp('login_time')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->string('username')->nullable();
            $table->unsignedInteger('numbers')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actions');
    }
}
