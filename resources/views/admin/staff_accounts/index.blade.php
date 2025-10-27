@extends('layouts.app')

@section('content')
    @include('admin._nav')

    <div class="max-w-5xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Staff accounts</h3>

            @if(session('success'))
                <div class="mb-4 text-green-700 bg-green-100 p-3 rounded">{{ session('success') }}</div>
            @endif

            <div class="space-y-3">
                @foreach($staffUsers as $u)
                    <div class="border rounded p-3 flex justify-between items-center">
                        <div>
                            <div class="font-medium">{{ $u->name }} <span class="text-sm text-gray-500">({{ $u->email }})</span></div>
                            <div class="text-sm text-gray-600">Status: {{ $u->is_active ? 'Active' : 'Pending approval' }}</div>
                        </div>
                        <div>
                            <form method="POST" action="{{ route('admin.staff.accounts.toggle', $u) }}">
                                @csrf
                                <button class="px-3 py-1 {{ $u->is_active ? 'bg-yellow-500' : 'bg-green-600 text-white' }} rounded">{{ $u->is_active ? 'Disable' : 'Approve' }}</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
