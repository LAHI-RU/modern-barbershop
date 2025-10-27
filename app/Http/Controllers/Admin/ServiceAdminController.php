<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceAdminController extends Controller
{
  public function index()
  {
    $services = Service::orderBy('name')->get();
    return view('admin.services.index', compact('services'));
  }

  public function create()
  {
    return view('admin.services.create');
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
      'duration_minutes' => 'required|integer|min:1',
      'price_cents' => 'required|integer|min:0',
    ]);

    Service::create($data);

    return redirect()->route('admin.services.index')->with('success', 'Service created.');
  }

  public function edit(Service $service)
  {
    return view('admin.services.edit', compact('service'));
  }

  public function update(Request $request, Service $service)
  {
    $data = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
      'duration_minutes' => 'required|integer|min:1',
      'price_cents' => 'required|integer|min:0',
    ]);

    $service->update($data);

    return redirect()->route('admin.services.index')->with('success', 'Service updated.');
  }

  public function destroy(Service $service)
  {
    $service->delete();
    return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
  }
}
