@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold text-gray-900">Admin dashboard</h1>
    <nav class="space-x-3">
      <a href="{{ route('admin.services.index') }}" class="text-sm text-indigo-600 hover:underline">Services</a>
      <a href="{{ route('admin.staff.index') }}" class="text-sm text-indigo-600 hover:underline">Staff</a>
      <a href="{{ route('admin.staff.bookings.index', ['staff' => 1]) }}" class="text-sm text-indigo-600 hover:underline">Bookings</a>
    </nav>
  </div>

  @include('admin._nav')

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white overflow-hidden shadow rounded-lg p-5">
      <div class="text-sm font-medium text-gray-500">Services</div>
      <div class="mt-2 text-3xl font-bold text-gray-900">{{ $servicesCount }}</div>
      <div class="mt-3 text-sm">
        <a href="{{ route('admin.services.index') }}" class="text-indigo-600 hover:underline">Manage services</a>
      </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg p-5">
      <div class="text-sm font-medium text-gray-500">Staff</div>
      <div class="mt-2 text-3xl font-bold text-gray-900">{{ $staffCount }}</div>
      <div class="mt-3 text-sm">
        <a href="{{ route('admin.staff.index') }}" class="text-indigo-600 hover:underline">Manage staff</a>
      </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg p-5">
      <div class="text-sm font-medium text-gray-500">Upcoming bookings</div>
      <div class="mt-2 text-3xl font-bold text-gray-900">{{ $upcomingBookings }}</div>
      <div class="mt-3 text-sm">
        <a href="{{ route('admin.staff.index') }}" class="text-indigo-600 hover:underline">View bookings by staff</a>
      </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg p-5">
      <div class="text-sm font-medium text-gray-500">Cancelled</div>
      <div class="mt-2 text-3xl font-bold text-gray-900">{{ $cancelled }}</div>
      <div class="mt-3 text-sm">
        <a href="{{ route('admin.services.index') }}" class="text-indigo-600 hover:underline">Audit cancellations</a>
      </div>
    </div>
  </div>

  <div class="mt-8">
    <div class="bg-white p-6 rounded-lg shadow">
      <h2 class="font-semibold text-lg">Quick actions</h2>
      <div class="mt-4 space-x-3">
        <a href="{{ route('admin.services.create') }}" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded">New service</a>
        <a href="{{ route('admin.staff.create') }}" class="inline-block px-4 py-2 border border-gray-200 rounded">New staff</a>
      </div>
    </div>
  </div>
</div>
@endsection
