<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;
use Illuminate\Support\Facades\File;

class ArchiveCurrencySeeder extends Seeder
{
    public function run(): void
    {
        $filePath = database_path('archive_data\currencies.csv');

        $file = fopen($filePath, "r");

        fgetcsv($file); // Skip header

        while (($row = fgetcsv($file, 2000, ",")) !== FALSE) {
            // $row[0] = currency_id
            // $row[1] = currency_name
            // $row[2] = currency_abbreviation
            // $row[3] = currency_sign

            Currency::create([
                'currency_id'           => $row[0],
                'user_id'               => 1,
                'currency_name'         => $row[1],
                'currency_abbreviation' => $row[2],
                'currency_sign'         => $row[3],
                'is_default_currency'   => ($row[2] === 'HUF'), // Set HUF as default
            ]);
        }

        fclose($file);
    }
}
