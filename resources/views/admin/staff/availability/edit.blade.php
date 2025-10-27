@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Availability — {{ $staff->name }}</h2>
@endsection

@section('content')
<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
    @include('admin._nav')
    <div class="bg-white shadow sm:rounded-lg p-6">
        <form method="POST" action="{{ route('admin.staff.availability.update', [$staff, $availability]) }}">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" name="date" value="{{ $availability->date->toDateString() }}" class="mt-1 block w-full border-gray-300 rounded" required />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Start time</label>
                        <input type="time" name="start_time" value="{{ \Carbon\Carbon::parse($availability->start_time)->format('H:i') }}" class="mt-1 block w-full border-gray-300 rounded" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">End time</label>
                        <input type="time" name="end_time" value="{{ \Carbon\Carbon::parse($availability->end_time)->format('H:i') }}" class="mt-1 block w-full border-gray-300 rounded" required />
                    </div>
                </div>

                <div class="text-right">
                    <a href="{{ route('admin.staff.availability.index', $staff) }}" class="mr-2 px-3 py-2 bg-gray-200 rounded">Back</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
