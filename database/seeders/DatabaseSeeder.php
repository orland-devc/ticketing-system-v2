<?php

namespace Database\Seeders;

use App\Models\BotSetting;
use App\Models\Office;
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
        $this->command->info('Added 10 users.');

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user = User::create([
            'last_name' => 'Sayson',
            'first_name' => 'Orland',
            'middle_name' => 'Dela Cruz',
            'role' => 'admin',
            'email' => 'orlandsayson30@gmail.com',
            'password' => bcrypt('orlandsayson30'),
            'profile_photo_path' => 'images/user/orland.jpg',
            // 'cover_path' => 'images/cover/1745508709861.png',
        ]);

        $this->command->info("Account {$user->email} created successfully.");

        $user2 = User::create([
            'last_name' => 'Aquino',
            'first_name' => 'Cmark',
            'middle_name' => 'Concha',
            'role' => 'head',
            'email' => 'cmark@gmail.com',
            'password' => bcrypt('orlandsayson30'),
            'profile_photo_path' => 'images/user/cmark.jpg',
            // 'cover_path' => 'images/cover/1745508709861.png',
        ]);

        $this->command->info("Account {$user2->email} created successfully.");

        $user3 = User::create([
            'student_id' => '21-SC-2147',
            'last_name' => 'Marbella',
            'first_name' => 'Levi',
            'middle_name' => 'Dela Cruz',
            'role' => 'student',
            'email' => 'levi@gmail.com',
            'password' => bcrypt('orlandsayson30'),
            'profile_photo_path' => 'images/user/levi.jpg',
            // 'cover_path' => 'images/cover/1745508709861.png',
        ]);

        $this->command->info("Account {$user3->email} created successfully.");

        $office1 = Office::create(['name' => 'Campus Executive Director']);
        $this->command->info("{$office1->name} has been created");

        $office2 = Office::create(['name' => 'Guidance and Admission Services']);
        $this->command->info("{$office2->name} has been created");

        $office3 = Office::create(['name' => 'Library Services']);
        $this->command->info("{$office3->name} has been created");

        $office4 = Office::create(['name' => 'Registrar']);
        $this->command->info("{$office4->name} has been created");

        $office5 = Office::create(['name' => 'Cashier']);
        $this->command->info("{$office5->name} has been created");

        $bot = BotSetting::create([
            'name' => 'PSU SmartBot',
            'profile_picture' => 'images/assets/bot.jpg',
            'character' => 'An AI assistant for Pangasinan State University San Carlos City Campus.',
            'role' => 'Helps with academic and campus-related queries only.',
            'personality' => 'Witty, confident, kind, and helpful. Sometimes talks in Filipino.',
            'behavior' => 'Refuse unrelated queries. Keep responses short (2-3 sentences).',
            'greeting_message' => 'PSU SmartBot here. Ready to help, just tell me what do you need.',
            'error_message' => "I'm having technical difficulties. Try again in a sec.",
        ]);
        $this->command->info("{$bot->name} has been created");
    }
}
