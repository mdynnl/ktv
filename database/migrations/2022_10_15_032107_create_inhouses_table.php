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
        Schema::create('inhouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->restrictOnDelete();
            $table->float('room_rate')->default(0.00);
            $table->dateTime('arrival');
            $table->dateTime('departure');
            $table->float('session_hours');
            $table->boolean('checkout_payment_done')->default(false);
            $table->boolean('checked_out')->default(false);
            $table->string('customer_id')->nullable();
            $table->float('sub_total')->default(0);
            $table->float('commercial_tax')->default(0);
            $table->float('commercial_tax_amount')->default(0);
            $table->float('service_tax')->default(0);
            $table->float('service_tax_amount')->default(0);
            $table->float('total')->default(0);
            $table->float('payment_type_id')->default(1);
            $table->string('remark')->nullable();
            $table->unsignedInteger('created_user_id');
            $table->unsignedInteger('updated_user_id')->nullable();
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
        Schema::dropIfExists('inhouses');
    }
};
