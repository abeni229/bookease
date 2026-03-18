<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\AppointmentController;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Pages de réservation publiques
Route::get('/reserver/{userId}', [BookingController::class, 'index'])->name('booking.index');
Route::get('/reserver/{userId}/slots', [BookingController::class, 'getSlots'])->name('booking.slots');
Route::post('/reserver/{userId}', [BookingController::class, 'store'])->name('booking.store');
Route::get('/confirmation/{appointmentId}', [BookingController::class, 'confirmation'])->name('booking.confirmation');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Routes protégées
Route::middleware('auth')->group(function () {

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Services
    Route::resource('services', ServiceController::class)
        ->except(['show', 'edit', 'create']);
    Route::patch('services/{service}/toggle', [ServiceController::class, 'toggle'])
        ->name('services.toggle');

    // Créneaux
    Route::resource('timeslots', TimeSlotController::class)
        ->except(['show', 'edit', 'create', 'update']);
    Route::patch('timeslots/{timeSlot}/toggle', [TimeSlotController::class, 'toggle'])
        ->name('timeslots.toggle');

    // Rendez-vous
    Route::resource('appointments', AppointmentController::class)
        ->except(['create', 'store', 'edit', 'update', 'show']);
    Route::patch('appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])
        ->name('appointments.confirm');
    Route::patch('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])
        ->name('appointments.cancel');
});

require __DIR__.'/auth.php';