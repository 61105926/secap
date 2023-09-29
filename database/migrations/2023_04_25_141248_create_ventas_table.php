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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->nullable();
            $table->unsignedBigInteger('id_client');
            $table->foreign('id_client')->references('id')->on('clients')->nullable();
            $table->json('id_product');

            $table->string('subtotal');
            $table->string('extra')->nullable();
            $table->string('total_price');
            $table->string('discount');
            $table->string('balance');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
