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
        Schema::create('auction_bid_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('User id of who bid on that auction');
            $table->foreignId('auction_product_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('brand_id')->nullable();
            $table->double('price')->nullable();
            $table->foreignId('unit_id')->nullable();
            $table->string('made_in')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('delivery_charge')->nullable();
            $table->integer('winner_status')->default(0)->comment('0="no winner", 1="winner selected"');
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
        Schema::dropIfExists('auction_bid_products');
    }
};
