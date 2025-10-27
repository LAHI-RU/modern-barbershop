<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StaffAccountsController extends Controller
{
  public function index()
  {
    $staffUsers = User::where('role', 'staff')->orderBy('name')->get();
    return view('admin.staff_accounts.index', compact('staffUsers'));
  }

  public function toggle(Request $request, User $user)
  {
    if ($user->role !== 'staff') {
      return redirect()->back()->with('error', 'User is not a staff account.');
    }

    $user->is_active = ! $user->is_active;
    $user->save();

    // if linked staff record exists, mirror the is_active flag
    if ($user->staff) {
      $user->staff->is_active = $user->is_active;
      $user->staff->save();
    }

    return redirect()->route('admin.staff.accounts.index')->with('success', 'Staff account updated.');
  }
}
