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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_no');
            $table->foreignId('table_id')->nullable();
            // $table->unsignedInteger('pax');
            // $table->string('cashier');
            $table->float('sub_total');
            // $table->float('discount_percent');
            // $table->float('discount_amount');
            // $table->float('commercial_tax');
            // $table->float('service_tax');
            // $table->unsignedInteger('payment_type_id');
            $table->boolean('is_paid')->default(false);
            // $table->boolean('is_occupied')->default(false);
            // $table->unsignedInteger('customer_id')->nullable();
            $table->foreignId('inhouse_id')->nullable()->constrained()->restrictOnDelete();
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
        Schema::dropIfExists('orders');
    }
};
