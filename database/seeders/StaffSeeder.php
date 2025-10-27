<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
  public function run(): void
  {
    $staff = [
      ['name' => 'Alex Cortez', 'bio' => 'Senior barber, 10 years experience.', 'is_active' => true],
      ['name' => 'Maya Rivera', 'bio' => 'Specialist in fades and modern styles.', 'is_active' => true],
      ['name' => 'Liam O\'Connor', 'bio' => 'Classic cuts and shaves.', 'is_active' => true],
    ];

    foreach ($staff as $s) {
      Staff::create($s);
    }
  }
}
