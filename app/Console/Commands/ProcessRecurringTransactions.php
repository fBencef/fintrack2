<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Models\RecurringTransaction;
use Carbon\Carbon;

class ProcessRecurringTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-recurring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates pending transaction entries from due recurring entries';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->startOfDay();
        //DEBUG
        $this->info("Checking for transactions due on or before: " . $today->toDateString());

        //Find active recurrings with due date today
        $recurrings = RecurringTransaction::where('recurring_is_active',true)
            ->where('next_execution_date','<=',$today)
            ->get();

        //DEBUG
        $this->info("Found " . $recurrings->count() . " templates to process.");

        $count = 0;
        foreach ($recurrings as $recurring) {
        // Create a pending Transaction entry
        Transaction::create([
            'user_id' => $recurring->user_id,
            'transaction_date_completed' => $recurring->next_execution_date,
            'transaction_amount' => $recurring->recurring_amount,
            'category_id' => $recurring->category_id,
            'subcategory_id' => $recurring->subcategory_id,
            'currency_id' => $recurring->currency_id,
            'account_id' => $recurring->account_id,
            'transaction_description' => $recurring->recurring_description . ' Automatikusan létrehozva.',
            'transaction_status' => 'pending',
            'is_split' => false,
        ]);

        //Calculate the next occurence
        $nextOccurence = match($recurring->frequency_type) {
            'daily'   => Carbon::parse($recurring->next_execution_date)->addDays($recurring->frequency_intervall),
            'weekly'  => Carbon::parse($recurring->next_execution_date)->addWeeks($recurring->frequency_intervall),
            'monthly' => Carbon::parse($recurring->next_execution_date)->addMonths($recurring->frequency_intervall),
            'yearly'  => Carbon::parse($recurring->next_execution_date)->addYears($recurring->frequency_intervall),
            default   => $recurring->next_execution_date->addMonths(1),
        };

        $recurring->update(['next_execution_date' => $nextOccurence]);

        $this->info('Generated pending transaction for: ' . $recurring->recurring_name);
        
        $count++;
    }

    $this->info('Successfully generated'. $count .'pending transactions.');
    }
}