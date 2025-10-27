@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Book an Appointment</h2>
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

        <form action="{{ route('booking.store') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="service_id" class="block text-sm font-medium text-gray-700">Service</label>
                    <select id="service_id" name="service_id" class="mt-1 block w-full border-gray-300 rounded focus:ring-2 focus:ring-indigo-500" required aria-required="true">
                        <option value="">Select a service</option>
                        @foreach($services as $s)
                            <option value="{{ $s->id }}" {{ request('service_id') == $s->id ? 'selected' : '' }}>{{ $s->name }} — {{ number_format($s->price_cents / 100, 2) }} USD</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="staff_id" class="block text-sm font-medium text-gray-700">Staff</label>
                    <select id="staff_id" name="staff_id" class="mt-1 block w-full border-gray-300 rounded focus:ring-2 focus:ring-indigo-500">
                        <option value="">Any available</option>
                        @foreach($staff as $st)
                            <option value="{{ $st->id }}">{{ $st->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                        <input id="date" type="date" name="date" class="mt-1 block w-full border-gray-300 rounded focus:ring-2 focus:ring-indigo-500" required aria-required="true" />
                    </div>
                    <div>
                        <label for="time" class="block text-sm font-medium text-gray-700">Time</label>
                        <div id="timeWrapper" class="mt-1">
                            <select id="time" name="time" class="block w-full border-gray-300 rounded focus:ring-2 focus:ring-indigo-500" required aria-required="true" aria-describedby="slotsStatus">
                                <option value="">Choose a date & service to see slots</option>
                            </select>
                            <div id="slotsStatus" class="sr-only" aria-live="polite" role="status"></div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Notes (optional)</label>
                    <textarea name="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded"></textarea>
                </div>

                <div class="text-right">
                    <button id="submitBtn" type="submit" class="px-4 py-2 bg-blue-600 text-white rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">Confirm booking</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function(){
    const serviceSelect = document.getElementById('service_id');
    const staffSelect = document.getElementById('staff_id');
        const dateInput = document.getElementById('date');
        const timeSelect = document.getElementById('time');
    const slotsStatus = document.getElementById('slotsStatus');
        const submitBtn = document.getElementById('submitBtn');

        function fetchSlots(){
            const serviceId = serviceSelect.value;
            const staffId = staffSelect.value;
            const date = dateInput.value;

            // reset
            timeSelect.innerHTML = '<option value="">Loading...</option>';
            slotsStatus.textContent = 'Loading available slots';
            timeSelect.setAttribute('aria-busy', 'true');
            submitBtn.disabled = true;

            // require at minimum service and date. staff is optional (Any available)
            if (!serviceId || !date) {
                timeSelect.innerHTML = '<option value="">Choose a date & service to see slots</option>';
                slotsStatus.textContent = '';
                timeSelect.removeAttribute('aria-busy');
                submitBtn.disabled = false;
                return;
            }

            const params = new URLSearchParams({ service_id: serviceId, staff_id: staffId, date: date });
            fetch(`{{ route('booking.slots') }}?` + params.toString(), {
                credentials: 'same-origin',
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            }).then(r => r.json()).then(json => {
                timeSelect.innerHTML = '';
                if (!json.slots || json.slots.length === 0) {
                    timeSelect.innerHTML = '<option value="">No available slots</option>';
                    slotsStatus.textContent = 'No available slots for the selected date.';
                } else {
                    timeSelect.innerHTML = '<option value="">Select a time</option>';
                    json.slots.forEach(s => {
                        const opt = document.createElement('option');
                        opt.value = s;
                        opt.textContent = s;
                        timeSelect.appendChild(opt);
                    });
                    slotsStatus.textContent = json.slots.length + ' available slots';
                }
                timeSelect.removeAttribute('aria-busy');
                submitBtn.disabled = false;
            }).catch(err => {
                timeSelect.innerHTML = '<option value="">Error loading slots</option>';
                slotsStatus.textContent = 'Error loading slots';
                timeSelect.removeAttribute('aria-busy');
                submitBtn.disabled = false;
                console.error(err);
            });
        }

        serviceSelect.addEventListener('change', fetchSlots);
        staffSelect.addEventListener('change', fetchSlots);
        dateInput.addEventListener('change', fetchSlots);

        // If the page was loaded with a pre-selected service (via query), try fetching after slight delay
        window.addEventListener('DOMContentLoaded', function(){
            if (serviceSelect.value || staffSelect.value) {
                setTimeout(fetchSlots, 250);
            }
        });
    })();
</script>
@endpush
