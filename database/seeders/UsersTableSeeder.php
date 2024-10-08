<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a default user
        User::create([
            'name' => 'Tester',
            'email' => 'test.email@example.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
