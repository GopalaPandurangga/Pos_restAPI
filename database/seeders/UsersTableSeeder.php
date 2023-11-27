<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(
            [
                'name' => "Admin",
                'email' => "admin@demo.com",
                'password' => bcrypt('12345678'), // Change 'password' to your desired default password
            ]
        );
    }
}
