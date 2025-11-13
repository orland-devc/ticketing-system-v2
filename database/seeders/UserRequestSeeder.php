<?php

namespace Database\Seeders;

use App\Models\UserRequest;
use Illuminate\Database\Seeder;

class UserRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserRequest::factory(1)->create();
        $this->command->info('Added 1 user requests.');

    }
}
