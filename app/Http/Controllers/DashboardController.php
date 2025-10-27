<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Staff;

class DashboardController extends Controller
{
  public function index(Request $request)
  {
    $user = $request->user();

    // If the user is a staff member, show the staff dashboard
    if ($user->role === 'staff') {
      return view('staff.dashboard');
    }

    $servicesCount = Service::count();
    $staffCount = Staff::count();
    $upcomingBookings = Appointment::where('user_id', $user->id)
      ->where('start_at', '>=', now())
      ->where('status', 'booked')
      ->count();

    return view('dashboard', compact('servicesCount', 'staffCount', 'upcomingBookings'));
  }
}
