<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffAdminController extends Controller
{
  public function index()
  {
    $staff = Staff::orderBy('name')->get();
    return view('admin.staff.index', compact('staff'));
  }

  public function create()
  {
    return view('admin.staff.create');
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'name' => 'required|string|max:255',
      'bio' => 'nullable|string',
      'is_active' => 'sometimes|boolean',
    ]);

    $data['is_active'] = $request->has('is_active');
    Staff::create($data);

    return redirect()->route('admin.staff.index')->with('success', 'Staff created.');
  }

  public function edit(Staff $staff)
  {
    return view('admin.staff.edit', compact('staff'));
  }

  public function update(Request $request, Staff $staff)
  {
    $data = $request->validate([
      'name' => 'required|string|max:255',
      'bio' => 'nullable|string',
      'is_active' => 'sometimes|boolean',
    ]);

    $data['is_active'] = $request->has('is_active');
    $staff->update($data);

    return redirect()->route('admin.staff.index')->with('success', 'Staff updated.');
  }

  public function destroy(Staff $staff)
  {
    $staff->delete();
    return redirect()->route('admin.staff.index')->with('success', 'Staff deleted.');
  }
}
