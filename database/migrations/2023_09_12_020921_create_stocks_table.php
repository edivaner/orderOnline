<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('affiliate_id');
            $table->unsignedBigInteger('product_id');
            $table->float('amount');
            $table->float('cost')->nullable();
            $table->float('saleValue');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('affiliate_id')->references('id')->on('affiliates');
            $table->foreign('product_id')->references('id')->on('products');

            $table->unique(['affiliate_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
