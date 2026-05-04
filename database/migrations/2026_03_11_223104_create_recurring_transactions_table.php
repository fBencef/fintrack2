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
        Schema::create('recurring_transactions', function (Blueprint $table) {
            $table->id('recurring_id');
            $table->foreignId('user_id')->constrained('users','user_id')->onDelete('cascade');
            $table->foreignId('currency_id')->constrained('currencies','currency_id')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories','category_id')->onDelete('cascade');
            $table->foreignId('subcategory_id')->constrained('subcategories','subcategory_id')->onDelete('cascade')->nullable();
            $table->foreignId('account_id')->constrained('accounts','account_id')->onDelete('cascade');
            $table->string('recurring_name');
            $table->string('recurring_description')->nullable();
            $table->decimal('recurring_amount',15,2);
            $table->date('recurring_start_date');
            $table->date('recurring_end_date')->nullable();
            $table->string('frequency_type');
            $table->integer('frequency_intervall')->default(1);
            $table->integer('day_of_recurrence')->nullable();
            $table->date('next_execution_date');
            $table->boolean('recurring_is_active')->default(true);
            $table->boolean('recurring_is_prediction');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_transactions');
    }
};
