<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!User::where('email', 'eduardobaranowski@gmail.com')->first()){
            User::create([
                'name' => 'Eduardo',
                'email' => 'eduardobaranowski@gmail.com',
                'password' => Hash::make('12345678',['rounds' => 12]),
            ]);
        }
    }
}
