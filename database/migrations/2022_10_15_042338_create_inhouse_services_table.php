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
            $table->foreignId('inhouse_id')->constrained()->restrictOnDelete();
            $table->foreignId('service_staff_id')->constrained('service_staff')->restrictOnDelete();
            $table->dateTime('checkin_time');
            $table->dateTime('checkout_time');
            $table->boolean('is_checked_out')->default(false);
            $table->float('session_hours');
            $table->float('service_staff_rate');
            $table->float('service_staff_commission_rate');
            $table->date('operation_date');
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
