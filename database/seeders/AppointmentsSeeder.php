<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AppointmentsSeeder extends Seeder
{
  public function run(): void
  {
    $user = User::first();
    $service = Service::first();
    $staff = Staff::first();

    if (! $user || ! $service || ! $staff) {
      return;
    }

    $start = Carbon::now()->addDays(1)->setTime(10, 0, 0);
    $end = (clone $start)->addMinutes($service->duration_minutes);

    Appointment::create([
      'user_id' => $user->id,
      'service_id' => $service->id,
      'staff_id' => $staff->id,
      'start_at' => $start,
      'end_at' => $end,
      'status' => 'booked',
      'notes' => 'Seeder sample appointment',
    ]);
  }
}
