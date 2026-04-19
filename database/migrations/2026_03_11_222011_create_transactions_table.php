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
            $table->id('transaction_id');
            $table->foreignId('user_id')->constrained('users','user_id')->onDelete('cascade');
            $table->foreignId('currency_id')->constrained('currencies','currency_id')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories','category_id')->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained('subcategories','subcategory_id')->onDelete('cascade');
            $table->foreignId('account_id')->constrained('accounts','account_id')->onDelete('cascade');
            $table->boolean('is_split')->default(false);
            $table->decimal('transaction_amount',15,2);
            $table->decimal('transaction_split_amount',15,2)->nullable();
            $table->dateTime('transaction_date_completed');
            $table->string('transaction_description')->nullable();
            $table->enum('transaction_status',['confirmed','pending','declined'])->default('confirmed');
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
