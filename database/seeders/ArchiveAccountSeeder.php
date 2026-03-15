<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\File;

class ArchiveAccountSeeder extends Seeder
{
    public function run(): void
    {
        // Get CSV path
        $filePath = database_path('archive_data\accounts.csv');

        $file = fopen($filePath, "r");
        
        // Skip header
        fgetcsv($file);

        // Read rows
        while (($row = fgetcsv($file, 2000, ",")) !== FALSE) {
            // $row[0] = account_id
            // $row[1] = currency_id
            // $row[2] = account_name
            // $row[3] = is_active

            Account::create([
                'account_id'   => $row[0],
                'user_id'      => 1,        //From UserSeeder
                'account_name' => $row[1],
                'currency_id'  => $row[2],
                'is_active'    => (bool)$row[3],
            ]);
        }

        fclose($file);
    }
}