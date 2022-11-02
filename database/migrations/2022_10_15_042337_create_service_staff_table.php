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
        Schema::create('service_staff', function (Blueprint $table) {
            $table->id();
            $table->string('name_on_nrc');
            $table->string('nick_name')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('full_size_image')->nullable();
            $table->string('nrc')->nullable()->unique();
            $table->date('dob')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->unique();
            $table->boolean('isActive')->default(false);
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
        Schema::dropIfExists('service_staff');
    }
};
