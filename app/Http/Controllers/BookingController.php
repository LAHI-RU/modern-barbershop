<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Availability;
use App\Models\Service;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class BookingController extends Controller
{
  public function create(Request $request)
  {
    $services = Service::all();
    $staff = Staff::where('is_active', true)->get();
    return view('booking.create', compact('services', 'staff'));
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'service_id' => 'required|exists:services,id',
      'staff_id' => 'required|exists:staff,id',
      'date' => 'required|date',
      'time' => 'required',
      'notes' => 'nullable|string',
    ]);

    $service = Service::findOrFail($data['service_id']);
    $staff = Staff::findOrFail($data['staff_id']);
    $startAt = Carbon::parse($data['date'] . ' ' . $data['time']);
    $endAt = (clone $startAt)->addMinutes($service->duration_minutes);

    // Basic availability check: staff must have availability for the date
    $availability = Availability::where('staff_id', $staff->id)
      ->where('date', $startAt->toDateString())
      ->first();

    if (! $availability) {
      return back()->withErrors(['date' => 'Selected staff is not available on that date.'])->withInput();
    }

    // Ensure requested time is within availability window
    if ($startAt->format('H:i:s') < $availability->start_time || $endAt->format('H:i:s') > $availability->end_time) {
      return back()->withErrors(['time' => 'Selected time is outside staff availability.'])->withInput();
    }

    // Check for overlapping appointments for the staff (standard overlap check)
    $conflict = Appointment::where('staff_id', $staff->id)
      ->where(function ($q) use ($startAt, $endAt) {
        $q->where('start_at', '<', $endAt)
          ->where('end_at', '>', $startAt);
      })->exists();

    if ($conflict) {
      return back()->withErrors(['time' => 'Selected time conflicts with another appointment.'])->withInput();
    }

    $appointment = Appointment::create([
      'user_id' => Auth::id(),
      'service_id' => $service->id,
      'staff_id' => $staff->id,
      'start_at' => $startAt,
      'end_at' => $endAt,
      'status' => 'booked',
      'notes' => $data['notes'] ?? null,
    ]);

    return redirect()->route('dashboard')->with('success', 'Appointment booked successfully.');
  }

  /**
   * Return available time slots for a staff+service+date combination.
   * Expects query params: staff_id, service_id, date (YYYY-MM-DD)
   */
  public function slots(Request $request)
  {
    $data = $request->validate([
      'staff_id' => 'required|exists:staff,id',
      'service_id' => 'required|exists:services,id',
      'date' => 'required|date',
    ]);

    $service = Service::findOrFail($data['service_id']);
    $staff = Staff::findOrFail($data['staff_id']);
    $date = Carbon::parse($data['date'])->toDateString();

    $availability = Availability::where('staff_id', $staff->id)
      ->where('date', $date)
      ->first();

    if (! $availability) {
      return response()->json(['slots' => []]);
    }

    $start = Carbon::parse($date . ' ' . $availability->start_time);
    $end = Carbon::parse($date . ' ' . $availability->end_time);
    $duration = $service->duration_minutes;

    $slots = [];

    for ($cursor = $start->copy(); $cursor->addMinutes(0)->lt($end); $cursor->addMinutes($duration)) {
      $slotStart = $cursor->copy();
      $slotEnd = $slotStart->copy()->addMinutes($duration);

      if ($slotEnd->gt($end)) {
        break; // slot would run past availability window
      }

      // check overlap with existing appointments
      $overlap = Appointment::where('staff_id', $staff->id)
        ->where(function ($q) use ($slotStart, $slotEnd) {
          $q->where('start_at', '<', $slotEnd)
            ->where('end_at', '>', $slotStart);
        })->exists();

      if (! $overlap && $slotStart->isFuture()) {
        $slots[] = $slotStart->format('H:i');
      }
    }

    return response()->json(['slots' => $slots]);
  }

  /**
   * List bookings for the authenticated user.
   */
  public function index(Request $request)
  {
    $appointments = Appointment::where('user_id', Auth::id())
      ->orderBy('start_at', 'asc')
      ->get();

    return view('bookings.index', compact('appointments'));
  }

  /**
   * Show edit (reschedule) form for an appointment.
   */
  public function edit(Request $request, Appointment $appointment)
  {
    if ($appointment->user_id !== Auth::id()) {
      abort(403);
    }

    $services = Service::all();
    $staff = Staff::where('is_active', true)->get();

    return view('bookings.edit', compact('appointment', 'services', 'staff'));
  }

  /**
   * Update (reschedule) the appointment.
   */
  public function update(Request $request, Appointment $appointment): RedirectResponse
  {
    if ($appointment->user_id !== Auth::id()) {
      abort(403);
    }

    $data = $request->validate([
      'service_id' => 'required|exists:services,id',
      'staff_id' => 'required|exists:staff,id',
      'date' => 'required|date',
      'time' => 'required',
    ]);

    $service = Service::findOrFail($data['service_id']);
    $staff = Staff::findOrFail($data['staff_id']);

    $startAt = Carbon::parse($data['date'] . ' ' . $data['time']);
    $endAt = (clone $startAt)->addMinutes($service->duration_minutes);

    // availability check
    $availability = Availability::where('staff_id', $staff->id)
      ->where('date', $startAt->toDateString())
      ->first();

    if (! $availability) {
      return back()->withErrors(['date' => 'Selected staff is not available on that date.'])->withInput();
    }

    if ($startAt->format('H:i:s') < $availability->start_time || $endAt->format('H:i:s') > $availability->end_time) {
      return back()->withErrors(['time' => 'Selected time is outside staff availability.'])->withInput();
    }

    // overlapping check excluding this appointment
    $conflict = Appointment::where('staff_id', $staff->id)
      ->where('id', '!=', $appointment->id)
      ->where(function ($q) use ($startAt, $endAt) {
        $q->where('start_at', '<', $endAt)
          ->where('end_at', '>', $startAt);
      })->exists();

    if ($conflict) {
      return back()->withErrors(['time' => 'Selected time conflicts with another appointment.'])->withInput();
    }

    $appointment->update([
      'service_id' => $service->id,
      'staff_id' => $staff->id,
      'start_at' => $startAt,
      'end_at' => $endAt,
      'status' => 'booked',
    ]);

    return redirect()->route('bookings.index')->with('success', 'Appointment rescheduled successfully.');
  }

  /**
   * Cancel a booking (soft cancel by setting status).
   */
  public function destroy(Request $request, Appointment $appointment): RedirectResponse
  {
    if ($appointment->user_id !== Auth::id()) {
      abort(403);
    }

    $appointment->update(['status' => 'cancelled']);

    return redirect()->route('bookings.index')->with('success', 'Appointment cancelled.');
  }
}
