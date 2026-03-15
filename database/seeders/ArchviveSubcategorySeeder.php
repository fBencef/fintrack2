<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subcategory;
use Illuminate\Support\Facades\File;

class ArchiveSubcategorySeeder extends Seeder
{
    public function run(): void
    {
        $filePath = database_path('archive_data\subcategories.csv');

        $file = fopen($filePath, "r");

        fgetcsv($file);

        while (($row = fgetcsv($file, 2000, ",")) !== FALSE) {
            // $row[0] = subcategory_id
            // $row[1] = category_id
            // $row[2] = subcategory_name
            // $row[3] = subcategory_description

            Subcategory::create([
                'subcategory_id'          => $row[0],
                'user_id'                 => 1,
                'category_id'             => $row[1],
                'subcategory_name'        => $row[2],
                'subcategory_description' => $row[3] ?: null,
                'subcategory_is_active'   => true,
            ]);
        }

        fclose($file);
    }
}
