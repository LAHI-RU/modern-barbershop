<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Availability;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StaffBookingsController extends Controller
{
  public function index(Staff $staff)
  {
    $appointments = Appointment::where('staff_id', $staff->id)
      ->orderBy('start_at', 'asc')
      ->get();

    $annotated = $appointments->map(function ($a) use ($staff) {
      $date = $a->start_at->toDateString();
      $availability = Availability::where('staff_id', $staff->id)->where('date', $date)->first();

      $isOutsideAvailability = false;
      if (! $availability) {
        $isOutsideAvailability = true;
      } else {
        $start = Carbon::parse($availability->start_time);
        $end = Carbon::parse($availability->end_time);
        $aStart = Carbon::parse($a->start_at->format('H:i'));
        $aEnd = Carbon::parse($a->end_at->format('H:i'));
        if ($aStart->lt($start) || $aEnd->gt($end)) {
          $isOutsideAvailability = true;
        }
      }

      // overlapping appointments for same staff (exclude self)
      $overlap = Appointment::where('staff_id', $staff->id)
        ->where('id', '!=', $a->id)
        ->where(function ($q) use ($a) {
          $q->where('start_at', '<', $a->end_at)
            ->where('end_at', '>', $a->start_at);
        })->exists();

      return [
        'appointment' => $a,
        'outside_availability' => $isOutsideAvailability,
        'overlap' => $overlap,
      ];
    });

    return view('admin.staff.bookings.index', compact('staff', 'annotated'));
  }

  public function cancel(Request $request, Staff $staff, Appointment $appointment)
  {
    // allow admin to cancel any appointment for the staff
    if ($appointment->staff_id !== $staff->id) {
      abort(400);
    }

    $appointment->status = 'cancelled';
    $appointment->save();

    return redirect()->route('admin.staff.bookings.index', $staff)->with('success', 'Appointment cancelled.');
  }
}
