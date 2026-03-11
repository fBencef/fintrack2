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
        Schema::create('debts', function (Blueprint $table) {
            $table->id("debt_id");
            $table->foreignId('user_id');
            $table->foreignId('currency_id');
            $table->foreignId('partner_id');
            $table->foreignId('debt_status_id');
            $table->float('debt_amount');
            $table->date('debt_date_completed');
            $table->date('debt_deadline');
            $table->string('debt_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
