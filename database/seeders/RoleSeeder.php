<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'superadmin',
            'description' => 'can do anything',
        ]);
        Role::create([
            'name' => 'admin',
            'description' => 'can do anything except protected data',
        ]);
        Role::create([
            'name' => 'cosplayer',
            'description' => 'limited access',
        ]);
    }
}
