<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <a href="#main-content" class="skip-link" style="position:absolute;left:-999px;top:auto;width:1px;height:1px;overflow:hidden;z-index:1000;" onfocus="this.style.left='0';this.style.top='0';this.style.width='auto';this.style.height='auto';this.style.padding='8px';this.style.background='#111827';this.style.color='#fff';">Skip to content</a>
        <x-banner />

        @include('partials.navbar')

        <div class="min-h-screen bg-gray-100">
            {{-- keep Jetstream navigation-menu for off-canvas profile links on mobile if present --}}
            @if(View::exists('navigation-menu'))
                @livewire('navigation-menu')
            @endif

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main id="main-content" tabindex="-1">
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
