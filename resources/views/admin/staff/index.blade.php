@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Staff</h2>
@endsection

@section('content')
<div class="max-w-5xl mx-auto py-6 sm:px-6 lg:px-8">
    @include('admin._nav')
    <div class="bg-white shadow sm:rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Staff Members</h3>
            <a href="{{ route('admin.staff.create') }}" class="px-3 py-2 bg-green-600 text-white rounded">New Staff</a>
        </div>

        @if(session('success'))
            <div class="mb-4 text-green-700 bg-green-100 p-3 rounded">{{ session('success') }}</div>
        @endif

        <div class="space-y-3">
            @foreach($staff as $st)
                <div class="border rounded p-3 flex justify-between items-center">
                    <div>
                        <div class="font-medium">{{ $st->name }}</div>
                        <div class="text-sm text-gray-600">{{ $st->bio }}</div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.staff.edit', $st) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">Edit</a>
                        <form method="POST" action="{{ route('admin.staff.destroy', $st) }}" onsubmit="return confirm('Delete this staff member?');">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
