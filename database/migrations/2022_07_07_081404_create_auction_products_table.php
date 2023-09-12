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
        Schema::create('auction_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_id')->references('id')
                ->on('auctions');
            $table->foreignId('catalogue_id')->references('id')
                ->on('catalogues');


            $table->string('product_title')->nullable();
            $table->foreignId('brand_id')->nullable();
            $table->foreignId('unit_id')->nullable();
            $table->double('exact_item_require')->nullable();
            $table->foreignId('made_in')->nullable();
            $table->integer('quantity')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('winner_id')->nullable();
            $table->integer('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auction_products');
    }
};
