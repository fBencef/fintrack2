<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class ArchiveCategorySeeder extends Seeder
{
    public function run(): void
    {
        $filePath = database_path('archive_data>\categories.csv');

        $file = fopen($filePath, "r");
        
        fgetcsv($file); // Skip header

        while (($row = fgetcsv($file, 2000, ",")) !== FALSE) {
            // $row[0] = category_id
            // $row[1] = category_name
            // $row[2] = category_description
            // $row[3] = category_direction

            Category::create([
                'category_id'          => $row[0],
                'user_id'              => 1,
                'category_name'        => $row[1],
                'category_description' => $row[2] ?: null, // Handle empty
                'category_direction'   => $row[3],
                'category_is_active'   => true, 
            ]);
        }

        fclose($file);
    }
}
