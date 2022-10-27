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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('store_id');
            $table->date('purchase_date');
            $table->unsignedBigInteger('invoice_no')->nullable();
            $table->foreignId('supplier_id')->nullable();
            $table->date('due_date')->nullable();
            $table->float('total')->default(0);
            $table->float('discount')->default(0);
            $table->float('tax')->default(0);
            $table->float('amount')->default(0);
            $table->foreignId('payment_type_id');
            $table->boolean('is_paid')->default(false);
            $table->unsignedInteger('created_user_id');
            $table->unsignedInteger('updated_user_id')->nullable();
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
        Schema::dropIfExists('purchases');
    }
};
