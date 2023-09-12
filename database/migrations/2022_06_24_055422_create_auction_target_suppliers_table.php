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
        Schema::create('auction_target_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_id');

//            $table->foreignId('auction_id')->references('id')
//                ->on('auctions');

//            $table->foreignId('supplier_id')->comment('Supplier id as user')
//                ->references('id')->on('users');

            $table->foreignId('supplier_id');

            $table->unique(array('auction_id', 'supplier_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auction_target_suppliers');
    }
};
