<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RecurringTransaction;

class RecurringTransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Disney+
        RecurringTransaction::create([
        'recurring_id' => 1,
        'user_id' => 1,
        'currency_id' => 1,
        'category_id' => 7,
        'subcategory_id' => 41,
        'account_id' => 1,
        'recurring_name' => 'Streaming',
        'recurring_amount' => 1990,
        'recurring_start_date' => '2026-05-06',
        'frequency_type' => 'monthly',
        'frequency_intervall' => 1,
        'next_execution_date' => '2026-05-06',
        'recurring_is_active' => true,
        'recurring_is_prediction' => false,
        ]);

        // Telekom
        RecurringTransaction::create([
        'recurring_id' => 2,
        'user_id' => 1,
        'currency_id' => 1,
        'category_id' => 7,
        'subcategory_id' => 12,
        'account_id' => 1,
        'recurring_name' => 'Internet, telefon',
        'recurring_amount' => 4800,
        'recurring_start_date' => '2026-05-06',
        'frequency_type' => 'monthly',
        'frequency_intervall' => 1,
        'next_execution_date' => '2026-05-06',
        'recurring_is_active' => true,
        'recurring_is_prediction' => true,
        ]);

        // Google tárhely
        RecurringTransaction::create([
        'recurring_id' => 3,
        'user_id' => 1,
        'currency_id' => 1,
        'category_id' => 7,
        'subcategory_id' => 42,
        'account_id' => 1,
        'recurring_name' => 'Google AI Pro',
        'recurring_amount' => 87900,
        'recurring_start_date' => '2026-09-01',
        'frequency_type' => 'yearly',
        'frequency_intervall' => 1,
        'next_execution_date' => '2026-09-01',
        'recurring_is_active' => true,
        'recurring_is_prediction' => false,
        ]);

        // GreenGo
        RecurringTransaction::create([
        'recurring_id' => 4,
        'user_id' => 1,
        'currency_id' => 1,
        'category_id' => 9,
        'subcategory_id' => 20,
        'account_id' => 1,
        'recurring_name' => 'GreenGo Green Plus',
        'recurring_amount' => 1690,
        'recurring_start_date' => '2026-05-19',
        'frequency_type' => 'monthly',
        'frequency_intervall' => 1,
        'next_execution_date' => '2026-05-19',
        'recurring_is_active' => true,
        'recurring_is_prediction' => false,
        ]);
    }
}