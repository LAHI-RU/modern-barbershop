@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
  <h1 class="text-2xl font-semibold mb-4">Staff Dashboard</h1>

  <div class="bg-white p-6 rounded shadow">
    <p class="text-sm text-gray-600">Welcome, {{ auth()->user()->name }}. Here are your upcoming appointments.</p>
    @php
      $staff = auth()->user()->staff;
      $appointments = $staff ? $staff->appointments()->with('service','user')->where('start_at', '>=', now())->orderBy('start_at')->get() : collect();
    @endphp

    @if($appointments->isEmpty())
      <div class="mt-4 text-sm text-gray-600">No upcoming appointments.</div>
    @else
      <div class="mt-4 space-y-3">
        @foreach($appointments as $a)
          <div class="border rounded p-3 flex justify-between items-center">
            <div>
              <div class="font-medium">{{ $a->user->name }} — {{ $a->service->name }}</div>
              <div class="text-sm text-gray-600">{{ $a->start_at->format('M d, Y H:i') }}</div>
            </div>
            <div class="flex items-center space-x-2">
              <form method="POST" action="{{ route('staff.booking.confirm', ['staff' => $staff->id, 'appointment' => $a->id]) }}">
                @csrf
                <button class="px-3 py-1 bg-green-600 text-white rounded">Confirm</button>
              </form>
              <form method="POST" action="{{ route('admin.staff.bookings.cancel', ['staff' => $staff->id, 'appointment' => $a->id]) }}">
                @csrf
                <button class="px-3 py-1 bg-red-600 text-white rounded">Cancel</button>
              </form>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</div>
@endsection
