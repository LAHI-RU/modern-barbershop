<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="flex items-center space-x-2">
                <svg class="h-10 w-10 text-indigo-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <rect width="24" height="24" rx="4" fill="#fff"/>
                    <path d="M6 3v18" stroke="#111827" stroke-width="2" stroke-linecap="round"/>
                    <path d="M9 3v18" stroke="#ef4444" stroke-width="2" stroke-linecap="round"/>
                    <path d="M12 3v18" stroke="#06b6d4" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <div class="text-lg font-bold">Modern Barbershop</div>
            </div>
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
