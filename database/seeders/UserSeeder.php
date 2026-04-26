<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::updateOrCreate(
    ['email' => '   '],
    [
        'name' => 'admin',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]
);
    }
}
