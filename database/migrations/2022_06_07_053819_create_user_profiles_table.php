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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('company_id')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('registration')->nullable();
            $table->string('vat')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->foreignId('category_id')->nullable();
            $table->string('neighbourhood')->nullable();
            $table->string('parent_category_id')->nullable();
            $table->foreignId('sub_category_id')->nullable();
            $table->string('reg_copy_doc')->nullable();
            $table->string('vat_copy_doc')->nullable();
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
        Schema::dropIfExists('user_profiles');
    }
};
