<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
  public function run(): void
  {
    $services = [
      ['name' => 'Classic Haircut', 'description' => 'A traditional men\'s haircut.', 'duration_minutes' => 30, 'price_cents' => 2000],
      ['name' => 'Beard Trim', 'description' => 'Precision beard shaping and trim.', 'duration_minutes' => 20, 'price_cents' => 1000],
      ['name' => 'Hot Towel Shave', 'description' => 'Relaxing straight-razor shave with hot towels.', 'duration_minutes' => 45, 'price_cents' => 3000],
      ['name' => 'Haircut + Beard', 'description' => 'Combo service for haircut and beard trim.', 'duration_minutes' => 50, 'price_cents' => 4000],
    ];

    foreach ($services as $s) {
      Service::create($s);
    }
  }
}
