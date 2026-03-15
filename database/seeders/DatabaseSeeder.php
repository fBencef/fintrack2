<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ArchiveCurrencySeeder::class,
            ArchiveAccountSeeder::class,
            ArchiveCategorySeeder::class,
            ArchiveSubcategorySeeder::class,
            ArchiveTransactionSeeder::class,
            // Other seeders (Currency, Account) will follow here
        ]);
    }
}
