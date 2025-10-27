@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $staff->name }} — Availability</h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    @include('admin._nav')
    <div class="bg-white shadow sm:rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Availability</h3>
            <a href="{{ route('admin.staff.availability.create', $staff) }}" class="px-3 py-2 bg-green-600 text-white rounded">Add Availability</a>
        </div>

        @if(session('success'))
            <div class="mb-4 text-green-700 bg-green-100 p-3 rounded">{{ session('success') }}</div>
        @endif

        @if($availabilities->isEmpty())
            <div class="text-gray-600">No availability set for this staff member.</div>
        @else
            <div class="space-y-3">
                @foreach($availabilities as $a)
                    <div class="border rounded p-3 flex justify-between items-center">
                        <div>
                            <div class="font-medium">{{ $a->date->format('M d, Y') }}</div>
                            <div class="text-sm text-gray-600">{{ \\Carbon\\Carbon::parse($a->start_time)->format('H:i') }} — {{ \\Carbon\\Carbon::parse($a->end_time)->format('H:i') }}</div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.staff.availability.edit', [$staff, $a]) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">Edit</a>
                            <form method="POST" action="{{ route('admin.staff.availability.destroy', [$staff, $a]) }}" onsubmit="return confirm('Delete availability?');">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
