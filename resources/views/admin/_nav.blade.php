<nav aria-label="Admin navigation" class="mb-6">
  <div class="bg-white shadow sm:rounded-lg p-4">
    <ul class="flex flex-wrap gap-3" role="menubar">
      <li role="none"><a role="menuitem" href="{{ route('admin.home') }}" class="px-3 py-2 rounded {{ request()->routeIs('admin.home') ? 'bg-indigo-600 text-white' : 'text-indigo-600' }}">Dashboard</a></li>
      <li role="none"><a role="menuitem" href="{{ route('admin.services.index') }}" class="px-3 py-2 rounded {{ request()->routeIs('admin.services.*') ? 'bg-indigo-600 text-white' : 'text-indigo-600' }}">Services</a></li>
      <li role="none"><a role="menuitem" href="{{ route('admin.staff.index') }}" class="px-3 py-2 rounded {{ request()->routeIs('admin.staff.*') ? 'bg-indigo-600 text-white' : 'text-indigo-600' }}">Staff</a></li>
      <li role="none"><a role="menuitem" href="{{ route('admin.staff.bookings.index', ['staff' => optional(App\\Models\\Staff::first())->id ?: 1]) }}" class="px-3 py-2 rounded text-indigo-600">Bookings</a></li>
    </ul>
  </div>
</nav>
