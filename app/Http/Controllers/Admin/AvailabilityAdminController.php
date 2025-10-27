<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\Staff;
use Illuminate\Http\Request;

class AvailabilityAdminController extends Controller
{
  public function index(Staff $staff)
  {
    $availabilities = $staff->availabilities()->orderBy('date')->get();
    return view('admin.staff.availability.index', compact('staff', 'availabilities'));
  }

  public function create(Staff $staff)
  {
    return view('admin.staff.availability.create', compact('staff'));
  }

  public function store(Request $request, Staff $staff)
  {
    $data = $request->validate([
      'date' => 'required|date',
      'start_time' => 'required|date_format:H:i',
      'end_time' => 'required|date_format:H:i|after:start_time',
    ]);

    $data['staff_id'] = $staff->id;
    Availability::create($data);

    return redirect()->route('admin.staff.availability.index', $staff)->with('success', 'Availability added.');
  }

  public function edit(Staff $staff, Availability $availability)
  {
    return view('admin.staff.availability.edit', compact('staff', 'availability'));
  }

  public function update(Request $request, Staff $staff, Availability $availability)
  {
    $data = $request->validate([
      'date' => 'required|date',
      'start_time' => 'required|date_format:H:i',
      'end_time' => 'required|date_format:H:i|after:start_time',
    ]);

    $availability->update($data);

    return redirect()->route('admin.staff.availability.index', $staff)->with('success', 'Availability updated.');
  }

  public function destroy(Staff $staff, Availability $availability)
  {
    $availability->delete();
    return redirect()->route('admin.staff.availability.index', $staff)->with('success', 'Availability removed.');
  }
}
