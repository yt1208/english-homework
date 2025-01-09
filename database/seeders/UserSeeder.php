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
        User::insert([
            [
              'student_id' => '001',
              'name' => 'user',
              'email' => 'user@example.com',
              'password' => Hash::make('userpass')
            ]
          ]);
    }
}
