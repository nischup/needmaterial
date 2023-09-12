<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('user_type')->nullable();
            $table->string('buying_service_type')->nullable();
            $table->string('selling_service_type')->nullable();
            $table->string('quot_service_type')->nullable();
            $table->string('advertising_service_type')->nullable();
            $table->integer('no_of_buy_req')->nullable();
            $table->integer('no_of_sell_req')->nullable();
            $table->integer('no_of_quot_req')->nullable();
            $table->integer('no_of_adver_req')->nullable();
            $table->string('no_of_month')->unique();
            $table->string('fees')->unique();
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
        Schema::dropIfExists('subscriptions');
    }
};
