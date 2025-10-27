<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user and seed initial app data (idempotent)
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'is_admin' => true, 'password' => bcrypt('password')]
        );

        // Seed services, staff, availabilities and some appointments
        $this->call([
            ServicesSeeder::class,
            StaffSeeder::class,
            AvailabilitySeeder::class,
            AppointmentsSeeder::class,
        ]);
    }
}
