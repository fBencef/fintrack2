<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'user_id'    => 0, 
            'username'   => 'dev',
            'given_name' => 'Development User',
            'email'      => 'fbencef@stud.uni-obuda.hu',
            'password'   => Hash::make('pass'),
        ]);
    }
}