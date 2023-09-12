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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->tinyInteger('service_type')->default(1)->comment('1: Buying bid (Reverse) 2: Quotation 3: Selling bid');
            $table->boolean('is_open_bid')->default(1);
            $table->string('title');
            $table->tinyInteger('featured')->default(0)->comment('0: NO 1: YES');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('delivery_address')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->boolean('included_delivery_cost')->default(1);
            $table->boolean('vat')->default(0);
            $table->date('delivery_date')->nullable();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('auctions');
    }
};
