@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $service->name }}</h2>
@endsection

@section('content')
<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
        <h3 class="text-2xl font-bold">{{ $service->name }}</h3>
        <p class="mt-2 text-gray-700">{{ $service->description }}</p>
        <div class="mt-4">
            <span class="font-semibold">Duration:</span> {{ $service->duration_minutes }} minutes
        </div>
        <div class="mt-2">
            <span class="font-semibold">Price:</span> {{ number_format($service->price_cents / 100, 2) }} USD
        </div>

        <div class="mt-6">
            <a href="{{ route('booking.create', ['service_id' => $service->id]) }}" class="px-4 py-2 bg-green-600 text-white rounded">Book this service</a>
        </div>
    </div>
</div>
@endsection
