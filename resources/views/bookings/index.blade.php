@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Bookings</h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
        @if(session('success'))
            <div class="mb-4 text-green-700 bg-green-100 p-3 rounded">{{ session('success') }}</div>
        @endif

        @if($appointments->isEmpty())
            <div class="text-center text-gray-600">You have no upcoming bookings.</div>
        @else
            <ul class="space-y-4">
                @foreach($appointments as $a)
                    <li class="border rounded-lg p-4 flex justify-between items-center">
                        <div>
                            <div class="text-lg font-semibold">{{ $a->service->name ?? 'Service' }}</div>
                            <div class="text-sm text-gray-600">with {{ $a->staff->name ?? 'Staff' }} • {{ $a->start_at->format('M d, Y') }} at {{ $a->start_at->format('H:i') }}</div>
                            @if($a->notes)
                                <div class="mt-2 text-sm text-gray-700">Notes: {{ $a->notes }}</div>
                            @endif
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($a->status !== 'cancelled')
                                <a href="{{ route('bookings.edit', $a) }}" class="px-3 py-2 bg-yellow-500 text-white rounded">Reschedule</a>
                                <form action="{{ route('bookings.destroy', $a) }}" method="POST" onsubmit="return confirm('Cancel this appointment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded">Cancel</button>
                                </form>
                            @else
                                <span class="text-sm text-gray-500">Cancelled</span>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
