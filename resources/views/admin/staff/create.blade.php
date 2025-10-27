@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Staff</h2>
@endsection

@section('content')
<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
    @include('admin._nav')
    <div class="bg-white shadow sm:rounded-lg p-6">
        <form method="POST" action="{{ route('admin.staff.store') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input name="name" class="mt-1 block w-full border-gray-300 rounded" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Bio</label>
                    <textarea name="bio" class="mt-1 block w-full border-gray-300 rounded"></textarea>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" class="form-checkbox" checked>
                        <span class="ml-2">Active</span>
                    </label>
                </div>

                <div class="text-right">
                    <a href="{{ route('admin.staff.index') }}" class="mr-2 px-3 py-2 bg-gray-200 rounded">Back</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
