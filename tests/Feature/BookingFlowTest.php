<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Availability;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingFlowTest extends TestCase
{
  use RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();
    // run the migrations and seed minimal data
    $this->seed();
  }

  public function test_user_can_create_booking()
  {
    $user = User::factory()->create();
    $service = Service::first();
    $staff = Staff::first();

    $date = Carbon::today()->addDays(2)->toDateString();
    Availability::create(['staff_id' => $staff->id, 'date' => $date, 'start_time' => '09:00:00', 'end_time' => '17:00:00']);

    $response = $this->actingAs($user)->post(route('booking.store'), [
      'service_id' => $service->id,
      'staff_id' => $staff->id,
      'date' => $date,
      'time' => '10:00',
    ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertDatabaseHas('appointments', ['user_id' => $user->id, 'service_id' => $service->id, 'staff_id' => $staff->id]);
  }

  public function test_user_can_reschedule_own_booking()
  {
    $user = User::factory()->create();
    $service = Service::first();
    $staff = Staff::first();

    $date = Carbon::today()->addDays(3)->toDateString();
    Availability::create(['staff_id' => $staff->id, 'date' => $date, 'start_time' => '09:00:00', 'end_time' => '17:00:00']);

    $start = Carbon::parse($date . ' 11:00');
    $end = (clone $start)->addMinutes($service->duration_minutes);

    $appointment = Appointment::create([
      'user_id' => $user->id,
      'service_id' => $service->id,
      'staff_id' => $staff->id,
      'start_at' => $start,
      'end_at' => $end,
      'status' => 'booked',
    ]);

    $newDate = Carbon::today()->addDays(4)->toDateString();
    Availability::create(['staff_id' => $staff->id, 'date' => $newDate, 'start_time' => '09:00:00', 'end_time' => '17:00:00']);

    $response = $this->actingAs($user)->put(route('bookings.update', $appointment), [
      'service_id' => $service->id,
      'staff_id' => $staff->id,
      'date' => $newDate,
      'time' => '10:00',
    ]);

    $response->assertRedirect(route('bookings.index'));
    $this->assertDatabaseHas('appointments', ['id' => $appointment->id, 'start_at' => Carbon::parse($newDate . ' 10:00')->toDateTimeString()]);
  }

  public function test_user_can_cancel_own_booking()
  {
    $user = User::factory()->create();
    $service = Service::first();
    $staff = Staff::first();

    $start = Carbon::now()->addDays(2)->setTime(12, 0, 0);
    $end = (clone $start)->addMinutes($service->duration_minutes);

    $appointment = Appointment::create([
      'user_id' => $user->id,
      'service_id' => $service->id,
      'staff_id' => $staff->id,
      'start_at' => $start,
      'end_at' => $end,
      'status' => 'booked',
    ]);

    $response = $this->actingAs($user)->delete(route('bookings.destroy', $appointment));

    $response->assertRedirect(route('bookings.index'));
    $this->assertDatabaseHas('appointments', ['id' => $appointment->id, 'status' => 'cancelled']);
  }

  public function test_admin_can_cancel_any_booking()
  {
    $admin = User::factory()->create(['is_admin' => true]);
    $user = User::factory()->create();
    $service = Service::first();
    $staff = Staff::first();

    $start = Carbon::now()->addDays(2)->setTime(14, 0, 0);
    $end = (clone $start)->addMinutes($service->duration_minutes);

    $appointment = Appointment::create([
      'user_id' => $user->id,
      'service_id' => $service->id,
      'staff_id' => $staff->id,
      'start_at' => $start,
      'end_at' => $end,
      'status' => 'booked',
    ]);

    $response = $this->actingAs($admin)->post(route('admin.staff.bookings.cancel', [$staff, $appointment]));

    $response->assertRedirect(route('admin.staff.bookings.index', $staff));
    $this->assertDatabaseHas('appointments', ['id' => $appointment->id, 'status' => 'cancelled']);
  }
}
