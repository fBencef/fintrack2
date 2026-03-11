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
        Schema::create('debt_statuses', function (Blueprint $table) {
            $table->id("debt_status_id");
            $table->foreignId('user_id');
            $table->string('debt_status_name');
            $table->string('debt_status_color',7);
            $table->boolean('is_delay');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debt_statuses');
    }
};
