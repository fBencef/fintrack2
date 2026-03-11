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
            $table->foreignId('user_id');
            $table->foreignId('currency_id');
            $table->foreignId('category_id');
            $table->foreignId('subcategory_id');
            $table->foreignId('account_id');
            $table->string('recurring_name');
            $table->string('recurring_description');
            $table->float('recurring_amount');
            $table->date('recurring_start_date');
            $table->date('recurring_end_date');
            $table->string('frequency_type');
            $table->integer('frequency_intervall');
            $table->integer('day_of_recurrence');
            $table->date('next_exection_date');
            $table->boolean('recurring_is_active');
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
