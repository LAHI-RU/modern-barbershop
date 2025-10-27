@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Staff</h2>
@endsection

@section('content')
<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
    @include('admin._nav')
    <div class="bg-white shadow sm:rounded-lg p-6">
        <form method="POST" action="{{ route('admin.staff.update', $staff) }}">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input name="name" value="{{ $staff->name }}" class="mt-1 block w-full border-gray-300 rounded" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Bio</label>
                    <textarea name="bio" class="mt-1 block w-full border-gray-300 rounded">{{ $staff->bio }}</textarea>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" class="form-checkbox" {{ $staff->is_active ? 'checked' : '' }}>
                        <span class="ml-2">Active</span>
                    </label>
                </div>

                <div class="text-right">
                    <a href="{{ route('admin.staff.index') }}" class="mr-2 px-3 py-2 bg-gray-200 rounded">Back</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="max-w-3xl mx-auto py-4 sm:px-6 lg:px-8">
    <div class="text-right max-w-3xl mx-auto">
        <a href="{{ route('admin.staff.availability.index', $staff) }}" class="px-3 py-2 bg-indigo-600 text-white rounded">Manage Availability</a>
    </div>
</div>
@endsection
