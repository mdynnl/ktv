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
        Schema::create('inhouse_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inhouse_id');
            $table->foreignId('food_id');
            $table->float('price');
            $table->unsignedInteger('qty');
            $table->unsignedInteger('order_time');
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('inhouse_orders');
    }
};
