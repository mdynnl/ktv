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
        Schema::create('check_out_payments', function (Blueprint $table) {
            $table->id();
            $table->date('payment_date');
            $table->foreignId('inhouse_id');
            // $table->string('department_code');
            // $table->string('currency_code');
            $table->float('amount');
            // $table->string('payment_currency_code');
            // $table->float('exchange_rate');
            $table->float('payment');
            $table->integer('payment_type_id');
            $table->string('remark');
            $table->integer('created_user_id');
            $table->integer('updated_user_id')->nullable();
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
        Schema::dropIfExists('check_out_payments');
    }
};
