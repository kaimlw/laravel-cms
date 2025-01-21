<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Web;
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
        Web::create([
            'id' => 1,
            'name' => 'Pendidikan Komputer',
            'subdomain' => 'pilkom'
        ]);
        User::create([
            'web_id' => '1',
            'display_name' => 'Admin Pendidikan Komputer',
            'username' => 'pilkom-admin',
            'password' => password_hash("admin", PASSWORD_DEFAULT),
            'email' => 'english.fkip@ulm.ac.id',
            'roles' => 'web_admin'
        ]);
        Category::create([
            'web_id' => '1',
            'name' => 'Tak berkategori',
            'slug' => 'uncategorized',
            'description' => '',
        ]);
    }
}
