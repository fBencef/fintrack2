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
            $table->foreignId('user_id')->constrained('users','user_id')->onDelete('cascade');
            $table->foreignId('currency_id')->constrained('currencies','currency_id')->onDelete('cascade');
            $table->foreignId('partner_id')->constrained('partners','partner_id')->onDelete('cascade');
            $table->foreignId('debt_status_id')->constrained('debt_statuses','debt_status_id')->onDelete('cascade');
            $table->decimal('debt_amount',15,2);
            $table->date('debt_date_completed');
            $table->date('debt_deadline')->nullable();
            $table->string('debt_description')->nullable();
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
