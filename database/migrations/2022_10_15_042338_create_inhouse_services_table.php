<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inhouse_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inhouse_id');
            $table->foreignId('service_staff_id');
            $table->dateTime('checkin_time');
            $table->dateTime('checkout_time');
            $table->float('session_hours');
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
        Schema::dropIfExists('inhouse_services');
    }
};
