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
        // User::factory(10)->create();

        User::create([
            'web_id' => '0',
            'display_name' => 'Super Admin',
            'username' => 'admin',
            'password' => password_hash("admin", PASSWORD_DEFAULT),
            'email' => 'fkip@ulm.ac.id'
        ]);
    }
}
