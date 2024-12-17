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

        // $this->call(RoleSeeder::class); //1)untuk seed role

        //2)untuk seed 1 user
        // User::factory()->create([
        //     'name' => 'Nizar Khan',
        //     'email' => 'nizarkhan7071@gmail.com',
        //     'password' => bcrypt('password'),
        //     'role_id' => '1',
        //     'email_verified_at' => now(),
        // ]);
    }
}
