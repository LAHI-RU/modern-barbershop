<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class StaffController extends Controller
{
  public function confirm(Request $request, $staffId, Appointment $appointment)
  {
    $user = $request->user();
    $staff = $user->staff;
    if (! $staff || $staff->id != $staffId) {
      abort(403);
    }

    if ($appointment->staff_id !== $staff->id) {
      abort(400);
    }

    $appointment->status = 'booked';
    $appointment->save();

    return redirect()->back()->with('success', 'Appointment confirmed.');
  }
}
