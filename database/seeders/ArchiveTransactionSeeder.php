<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use Illuminate\Support\Facades\File;

class ArchiveTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = database_path('archive_data\transactions.csv');

        $file = fopen($filePath, "r");

        fgetcsv($file);

        while (($row = fgetcsv($file, 2100, ",")) !== FALSE) {
            // $row[0] = transaction_id,
            // $row[1] = amount,
            // $row[2] = currency_id
            // $row[3] = category_id,
            // $row[4] = subcategory_id,
            // $row[6] = date_completed
            // $row[7] = account_id,
            // $row[10] = comment

            Transaction::create([
                'transaction_id'             => $row[0],
                'transaction_amount'         => $row[1],
                'currency_id'                => $row[2],
                'category_id'                => $row[3],
                'subcategory_id'             => $row[4] ?: null,
                'transaction_date_completed' => $row[6],
                'account_id'                 => $row[7],
                'user_id'                    => 1,
                'transaction_description'    => $row[10] ?: null,
                'is_split'                   => false,
                'transaction_status'         => 'confirmed',
            ]);
        }

        fclose($file);
    }
}