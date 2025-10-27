<header class="bg-white shadow">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      <div class="flex items-center space-x-6">
        <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-800">{{ config('app.name', 'Barbershop') }}</a>

        <!-- Mobile menu button -->
        <button id="navToggle" class="sm:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500" aria-expanded="false" aria-controls="primary-navigation">
          <span class="sr-only">Open main menu</span>
          <svg id="navOpenIcon" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
          <svg id="navCloseIcon" class="h-6 w-6 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <nav id="primary-navigation" class="hidden sm:flex space-x-3" aria-label="Primary">
          <a href="{{ route('services.index') }}" class="px-2 py-1 rounded {{ request()->routeIs('services.*') ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:text-indigo-600' }}">Services</a>
          <a href="{{ route('booking.create') }}" class="px-2 py-1 rounded {{ request()->routeIs('booking.*') ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:text-indigo-600' }}">Book</a>
          <a href="{{ route('bookings.index') }}" class="px-2 py-1 rounded {{ request()->routeIs('bookings.*') ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:text-indigo-600' }}">My bookings</a>
        </nav>
      </div>

      <div class="hidden sm:flex items-center space-x-4">
        @auth
          @if(auth()->user()->is_admin)
            <a href="{{ route('admin.home') }}" class="px-3 py-1 rounded {{ request()->routeIs('admin.*') ? 'bg-indigo-600 text-white' : 'text-indigo-600' }}">Admin</a>
          @endif
          <a href="{{ route('profile.show') }}" class="text-gray-600 hover:text-indigo-600">Profile</a>
          <form method="POST" action="{{ route('logout') }}">@csrf <button type="submit" class="text-gray-600 hover:text-indigo-600">Logout</button></form>
        @else
          <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600">Log in</a>
          <a href="{{ route('register') }}" class="text-gray-600 hover:text-indigo-600">Register</a>
        @endauth
      </div>

      <!-- Mobile menu (small screens) -->
      <div id="mobileMenu" class="sm:hidden hidden mt-2 w-full">
        <div class="px-2 pt-2 pb-3 space-y-1">
          <a href="{{ route('services.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('services.*') ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:text-indigo-600' }}">Services</a>
          <a href="{{ route('booking.create') }}" class="block px-3 py-2 rounded {{ request()->routeIs('booking.*') ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:text-indigo-600' }}">Book</a>
          <a href="{{ route('bookings.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('bookings.*') ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:text-indigo-600' }}">My bookings</a>
          @auth
            @if(auth()->user()->is_admin)
              <a href="{{ route('admin.home') }}" class="block px-3 py-2 rounded {{ request()->routeIs('admin.*') ? 'bg-indigo-600 text-white' : 'text-indigo-600' }}">Admin</a>
            @endif
            <a href="{{ route('profile.show') }}" class="block px-3 py-2 rounded text-gray-600 hover:text-indigo-600">Profile</a>
            <form method="POST" action="{{ route('logout') }}">@csrf <button type="submit" class="w-full text-left px-3 py-2 rounded text-gray-600 hover:text-indigo-600">Logout</button></form>
          @else
            <a href="{{ route('login') }}" class="block px-3 py-2 rounded text-gray-600 hover:text-indigo-600">Log in</a>
            <a href="{{ route('register') }}" class="block px-3 py-2 rounded text-gray-600 hover:text-indigo-600">Register</a>
          @endauth
        </div>
      </div>
    </div>
  </div>

  <script>
    (function(){
      const toggle = document.getElementById('navToggle');
      const mobileMenu = document.getElementById('mobileMenu');
      const openIcon = document.getElementById('navOpenIcon');
      const closeIcon = document.getElementById('navCloseIcon');
      if (!toggle) return;
      toggle.addEventListener('click', function(){
        const expanded = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', String(!expanded));
        mobileMenu.classList.toggle('hidden');
        openIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
      });
    })();
  </script>
</header>
