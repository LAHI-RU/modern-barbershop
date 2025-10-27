<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Services listing
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

    // Booking flow
    Route::get('/book', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/book', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/book/slots', [BookingController::class, 'slots'])->name('booking.slots');

    // User bookings (dashboard)
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{appointment}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{appointment}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{appointment}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    // Admin area (restricted to admins via IsAdmin middleware)
    Route::middleware([\App\Http\Middleware\IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('home');
        Route::resource('services', \App\Http\Controllers\Admin\ServiceAdminController::class)->except(['show']);
        Route::resource('staff', \App\Http\Controllers\Admin\StaffAdminController::class)->except(['show']);
        // Staff user accounts (admin approval)
        Route::get('staff-accounts', [\App\Http\Controllers\Admin\StaffAccountsController::class, 'index'])->name('staff.accounts.index');
        Route::post('staff-accounts/{user}/toggle', [\App\Http\Controllers\Admin\StaffAccountsController::class, 'toggle'])->name('staff.accounts.toggle');
        // Staff availability management (nested)
        Route::get('staff/{staff}/availability', [\App\Http\Controllers\Admin\AvailabilityAdminController::class, 'index'])->name('staff.availability.index');
        Route::get('staff/{staff}/availability/create', [\App\Http\Controllers\Admin\AvailabilityAdminController::class, 'create'])->name('staff.availability.create');
        Route::post('staff/{staff}/availability', [\App\Http\Controllers\Admin\AvailabilityAdminController::class, 'store'])->name('staff.availability.store');
        Route::get('staff/{staff}/availability/{availability}/edit', [\App\Http\Controllers\Admin\AvailabilityAdminController::class, 'edit'])->name('staff.availability.edit');
        Route::put('staff/{staff}/availability/{availability}', [\App\Http\Controllers\Admin\AvailabilityAdminController::class, 'update'])->name('staff.availability.update');
        Route::delete('staff/{staff}/availability/{availability}', [\App\Http\Controllers\Admin\AvailabilityAdminController::class, 'destroy'])->name('staff.availability.destroy');
        // Staff bookings view & admin cancel
        Route::get('staff/{staff}/bookings', [\App\Http\Controllers\Admin\StaffBookingsController::class, 'index'])->name('staff.bookings.index');
        Route::post('staff/{staff}/bookings/{appointment}/cancel', [\App\Http\Controllers\Admin\StaffBookingsController::class, 'cancel'])->name('staff.bookings.cancel');
        // Staff user confirm/cancel routes (staff users)
        Route::post('staff/{staff}/bookings/{appointment}/confirm', [\App\Http\Controllers\StaffController::class, 'confirm'])->name('staff.booking.confirm');
    });
});
