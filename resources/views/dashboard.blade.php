@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-semibold mb-4">Welcome, {{ auth()->user()->name }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-5 rounded shadow">
            <div class="text-sm text-gray-500">Services</div>
            <div class="text-2xl font-bold">{{ $servicesCount ?? 0 }}</div>
            <div class="mt-2"><a href="{{ route('services.index') }}" class="text-indigo-600">Browse services</a></div>
        </div>

        <div class="bg-white p-5 rounded shadow">
            <div class="text-sm text-gray-500">Staff</div>
            <div class="text-2xl font-bold">{{ $staffCount ?? 0 }}</div>
            <div class="mt-2"><a href="{{ route('admin.staff.index') }}" class="text-indigo-600">View staff</a></div>
        </div>

        <div class="bg-white p-5 rounded shadow">
            <div class="text-sm text-gray-500">Your upcoming bookings</div>
            <div class="text-2xl font-bold">{{ $upcomingBookings ?? 0 }}</div>
            <div class="mt-2"><a href="{{ route('bookings.index') }}" class="text-indigo-600">Manage bookings</a></div>
        </div>
    </div>

    <div class="mt-8">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="font-semibold text-lg">Quick actions</h2>
            <div class="mt-4 space-x-3">
                <a href="{{ route('booking.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Make a booking</a>
                <a href="{{ route('services.index') }}" class="px-4 py-2 border border-gray-200 rounded">Browse services</a>
            </div>
        </div>
    </div>
</div>
@endsection
