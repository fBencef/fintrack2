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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transcation_id');
            $table->foreignId('user_id');
            $table->foreignId('currency_id');
            $table->foreignId('category_id');
            $table->foreignId('subcategory_id');
            $table->foreignId('account_id');
            $table->boolean('is_split');
            $table->float('transaction_amount');
            $table->float('transaction_split_amount');
            $table->dateTime('transaction_date_completed');
            $table->string('transaction_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
