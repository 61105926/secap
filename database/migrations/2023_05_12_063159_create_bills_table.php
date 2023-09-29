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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->nullable();
            $table->string('category');
            $table->string('name');
            $table->string('type_transfer')->nullable();
            $table->string('desposit')->nullable();
            $table->string('transfer')->nullable();
            $table->string('cash')->nullable();
            $table->string('amount');
            $table->string('total_amount');
            $table->string('quantity');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
