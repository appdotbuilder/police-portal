<?php

namespace Database\Seeders;

use App\Models\Cases;
use App\Models\Personnel;
use App\Models\User;
use Illuminate\Database\Seeder;

class PolicePortalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@police.gov',
        ]);

        // Create officer users
        $officers = User::factory()->officer()->count(5)->create();

        // Create regular users
        $users = User::factory()->count(5)->create();

        // Create personnel records
        Personnel::factory()->active()->count(20)->create();

        // Create cases with relationships
        Cases::factory()->count(30)->create([
            'assigned_officer_id' => $officers->random()->id,
            'created_by' => collect([$admin])->merge($officers)->merge($users)->random()->id,
        ]);

        // Create some high priority open cases
        Cases::factory()->open()->highPriority()->count(5)->create([
            'assigned_officer_id' => $officers->random()->id,
            'created_by' => collect([$admin])->merge($officers)->merge($users)->random()->id,
        ]);
    }
}