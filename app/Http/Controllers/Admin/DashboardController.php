<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Staff;
use App\Models\Appointment;

class DashboardController extends Controller
{
  public function index()
  {
    $servicesCount = Service::count();
    $staffCount = Staff::count();
    $upcomingBookings = Appointment::where('start_at', '>=', now())->where('status', 'booked')->count();
    $cancelled = Appointment::where('status', 'cancelled')->count();

    return view('admin.dashboard', compact('servicesCount', 'staffCount', 'upcomingBookings', 'cancelled'));
  }
}
