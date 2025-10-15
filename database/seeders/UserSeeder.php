<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
               // 👨‍💼 Administrator
        User::updateOrCreate(
            ['email' => 'admin@dostsdn.gov.ph'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password123'), // ✅ Laravel 12 recommended
                'user_type' => UserType::ADMIN,
            ]
        );

        // 👤 Regular User
        User::updateOrCreate(
            ['email' => 'user@dostsdn.gov.ph'],
            [
                'name' => 'Regular User',
                'password' => bcrypt('password123'),
                'user_type' => UserType::USER,
            ]
        );

        // 👥 Guest
        User::updateOrCreate(
            ['email' => 'guest@dostsdn.gov.ph'],
            [
                'name' => 'Guest User',
                'password' => bcrypt('password123'),
                'user_type' => UserType::GUEST,
            ]
        );
    }
}
