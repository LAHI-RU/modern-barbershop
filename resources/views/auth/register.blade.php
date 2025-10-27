<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            {{-- custom barber logo SVG --}}
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

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="role" value="{{ __('Account type') }}" />
                <div class="mt-2 flex items-center space-x-4">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="role" value="user" checked class="text-indigo-600" />
                        <span class="text-sm">Customer</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="role" value="staff" class="text-indigo-600" />
                        <span class="text-sm">Staff</span>
                    </label>
                </div>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
