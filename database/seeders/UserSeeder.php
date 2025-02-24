<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
                'photo' => 'images/Profile/default-profile.jpg',
                'role' => 0,
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
