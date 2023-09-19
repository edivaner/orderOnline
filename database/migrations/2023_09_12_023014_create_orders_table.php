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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("status");
            $table->unsignedBigInteger('affiliate_id');
            $table->unsignedBigInteger('custumer_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('affiliate_id')->references('id')->on('affiliates');
            $table->foreign('custumer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
