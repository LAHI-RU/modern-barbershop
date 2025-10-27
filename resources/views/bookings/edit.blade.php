@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reschedule Appointment</h2>
@endsection

@section('content')
<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
        @if ($errors->any())
            <div class="mb-4">
                <ul class="text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('bookings.update', $appointment) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Service</label>
                    <select name="service_id" id="service" class="mt-1 block w-full border-gray-300 rounded" required>
                        @foreach($services as $s)
                            <option value="{{ $s->id }}" {{ $appointment->service_id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Staff</label>
                    <select name="staff_id" id="staff" class="mt-1 block w-full border-gray-300 rounded" required>
                        @foreach($staff as $st)
                            <option value="{{ $st->id }}" {{ $appointment->staff_id == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date</label>
                        <input id="date" type="date" name="date" value="{{ $appointment->start_at->toDateString() }}" class="mt-1 block w-full border-gray-300 rounded" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Time</label>
                        <select id="time" name="time" class="mt-1 block w-full border-gray-300 rounded" required>
                            <option value="{{ $appointment->start_at->format('H:i') }}">{{ $appointment->start_at->format('H:i') }}</option>
                        </select>
                    </div>
                </div>

                <div class="text-right">
                    <a href="{{ route('bookings.index') }}" class="mr-2 px-3 py-2 bg-gray-200 rounded">Back</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    (function(){
        const serviceSelect = document.getElementById('service');
        const staffSelect = document.getElementById('staff');
        const dateInput = document.getElementById('date');
        const timeSelect = document.getElementById('time');

        function fetchSlots(){
            const serviceId = serviceSelect.value;
            const staffId = staffSelect.value;
            const date = dateInput.value;

            timeSelect.innerHTML = '<option>Loading...</option>';

            const params = new URLSearchParams({ service_id: serviceId, staff_id: staffId, date: date });
            fetch(`{{ route('booking.slots') }}?` + params.toString(), {
                credentials: 'same-origin',
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            }).then(r => r.json()).then(json => {
                timeSelect.innerHTML = '';
                if (!json.slots || json.slots.length === 0) {
                    timeSelect.innerHTML = '<option value="">No available slots</option>';
                } else {
                    timeSelect.innerHTML = '<option value="">Select a time</option>';
                    json.slots.forEach(s => {
                        const opt = document.createElement('option');
                        opt.value = s;
                        opt.textContent = s;
                        timeSelect.appendChild(opt);
                    });
                }
            }).catch(err => {
                timeSelect.innerHTML = '<option value="">Error loading slots</option>';
                console.error(err);
            });
        }

        serviceSelect.addEventListener('change', fetchSlots);
        staffSelect.addEventListener('change', fetchSlots);
        dateInput.addEventListener('change', fetchSlots);

        window.addEventListener('DOMContentLoaded', function(){
            // fetch updated slots with current values
            setTimeout(fetchSlots, 100);
        });
    })();
</script>
@endpush

@endsection
