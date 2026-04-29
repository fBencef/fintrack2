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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id('currency_id');
            $table->foreignId('user_id')->constrained('users','user_id')->onDelete('cascade');
            $table->string('currency_name');
            $table->string('currency_sign');
            $table->string('currency_abbreviation', 3);
            $table->boolean('is_default_currency')->default(false);
            $table->timestamps(); // Adds created_at and updated_at automatically
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
