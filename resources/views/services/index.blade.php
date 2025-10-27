@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Services
    </h2>
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($services as $service)
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium">{{ $service->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $service->description }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-semibold">{{ number_format($service->price_cents / 100, 2) }} USD</div>
                            <div class="text-xs text-gray-500">{{ $service->duration_minutes }} min</div>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('booking.create', ['service_id' => $service->id]) }}" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded">Book</a>
                        <a href="{{ route('services.show', $service) }}" class="ml-2 inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded">Details</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
