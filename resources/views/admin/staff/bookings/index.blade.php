@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $staff->name }} — Bookings</h2>
@endsection

@section('content')
<div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
    @include('admin._nav')
    <div class="bg-white shadow sm:rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Upcoming Bookings</h3>
            <a href="{{ route('admin.staff.index') }}" class="px-3 py-2 bg-gray-200 rounded">Back to staff</a>
        </div>

        @if(session('success'))
            <div class="mb-4 text-green-700 bg-green-100 p-3 rounded">{{ session('success') }}</div>
        @endif

        @if($annotated->isEmpty())
            <div class="text-gray-600">No bookings for this staff member.</div>
        @else
            <div class="space-y-4">
                @foreach($annotated as $item)
                    @php($a = $item['appointment'])
                    <div class="border rounded p-4 flex justify-between items-start">
                        <div>
                            <div class="text-lg font-semibold">{{ $a->service->name ?? 'Service' }} — {{ $a->start_at->format('M d, Y H:i') }}</div>
                            <div class="text-sm text-gray-600">Customer: {{ $a->user->name ?? $a->user_id }} • Status: <span class="font-medium">{{ ucfirst($a->status) }}</span></div>
                            @if($a->notes)
                                <div class="mt-2 text-sm">Notes: {{ $a->notes }}</div>
                            @endif
                            <div class="mt-2">
                                @if($item['outside_availability'])
                                    <span class="inline-block px-2 py-1 bg-red-100 text-red-700 rounded">Outside availability</span>
                                @endif
                                @if($item['overlap'])
                                    <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 rounded">Conflicts with another appointment</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            <a href="mailto:{{ $a->user->email ?? '' }}" class="px-3 py-1 bg-blue-600 text-white rounded">Contact</a>
                            @if($a->status !== 'cancelled')
                                <form method="POST" action="{{ route('admin.staff.bookings.cancel', [$staff, $a]) }}" onsubmit="return confirm('Cancel this appointment?');">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Cancel</button>
                                </form>
                            @else
                                <span class="text-sm text-gray-500">Cancelled</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
