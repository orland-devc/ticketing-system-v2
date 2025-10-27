<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $user = User::create([
        //     'last_name' => 'Sayson',
        //     'first_name' => 'Orland',
        //     'middle_name' => 'Dela Cruz',
        //     'role' => 'admin',
        //     'email' => 'orlandsayson30@gmail.com',
        //     'password' => bcrypt('orlandsayson30'),
        //     'profile_photo_path' => 'images/user/orland.jpg',
        //     // 'cover_path' => 'images/cover/1745508709861.png',
        // ]);

        // $this->command->info("Account {$user->email} created successfully.");

        // $user2 = User::create([
        //     'last_name' => 'Aquino',
        //     'first_name' => 'Cmark',
        //     'middle_name' => 'Concha',
        //     'role' => 'head',
        //     'email' => 'cmark@gmail.com',
        //     'password' => bcrypt('orlandsayson30'),
        //     'profile_photo_path' => 'images/user/cmark.jpg',
        //     // 'cover_path' => 'images/cover/1745508709861.png',
        // ]);

        // $this->command->info("Account {$user2->email} created successfully.");

        // $user3 = User::create([
        //     'student_id' => '21-SC-2147',
        //     'last_name' => 'Marbella',
        //     'first_name' => 'Levi',
        //     'middle_name' => 'Dela Cruz',
        //     'role' => 'student',
        //     'email' => 'levi@gmail.com',
        //     'password' => bcrypt('orlandsayson30'),
        //     'profile_photo_path' => 'images/user/levi.jpg',
        //     // 'cover_path' => 'images/cover/1745508709861.png',
        // ]);

        // $this->command->info("Account {$user3->email} created successfully.");
    }
}
