@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Service</h2>
@endsection

@section('content')
<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
    @include('admin._nav')
    <div class="bg-white shadow sm:rounded-lg p-6">
        <form method="POST" action="{{ route('admin.services.update', $service) }}">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input name="name" value="{{ $service->name }}" class="mt-1 block w-full border-gray-300 rounded" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" class="mt-1 block w-full border-gray-300 rounded">{{ $service->description }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Duration (minutes)</label>
                        <input type="number" name="duration_minutes" class="mt-1 block w-full border-gray-300 rounded" value="{{ $service->duration_minutes }}" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Price (cents)</label>
                        <input type="number" name="price_cents" class="mt-1 block w-full border-gray-300 rounded" value="{{ $service->price_cents }}" required />
                    </div>
                </div>

                <div class="text-right">
                    <a href="{{ route('admin.services.index') }}" class="mr-2 px-3 py-2 bg-gray-200 rounded">Back</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
