<?php

namespace Database\Seeders;

use App\Models\Availability;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AvailabilitySeeder extends Seeder
{
  public function run(): void
  {
    $staff = Staff::all();
    $today = Carbon::today();

    foreach ($staff as $member) {
      // create availability for next 7 days: 09:00 - 17:00
      for ($d = 0; $d < 7; $d++) {
        $date = $today->copy()->addDays($d)->toDateString();
        Availability::create([
          'staff_id' => $member->id,
          'date' => $date,
          'start_time' => '09:00:00',
          'end_time' => '17:00:00',
        ]);
      }
    }
  }
}
