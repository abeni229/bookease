<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\AppointmentController; 
use App\Http\Controllers\StatisticsController;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Pages de réservation publiques
Route::get('/reserver/{userId}', [BookingController::class, 'index'])
    ->middleware(['throttle:booking.index', 'spam.protection'])
    ->name('booking.index');
Route::get('/reserver/{userId}/slots', [BookingController::class, 'getSlots'])
    ->middleware(['throttle:booking.slots', 'spam.protection'])
    ->name('booking.slots');
Route::post('/reserver/{userId}', [BookingController::class, 'store'])
    ->middleware(['throttle:booking.store', 'spam.protection'])
    ->name('booking.store');
Route::get('/confirmation/{appointmentId}', [BookingController::class, 'confirmation'])
    ->middleware(['throttle:booking.index', 'spam.protection'])
    ->name('booking.confirmation');

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
    ->except(['show', 'edit', 'create', 'update'])
    ->parameters(['timeslots' => 'timeSlot']);
    Route::patch('timeslots/{timeSlot}/toggle', [TimeSlotController::class, 'toggle'])
    ->name('timeslots.toggle');

    // Rendez-vous
    Route::resource('appointments', AppointmentController::class)
        ->except(['create', 'store', 'edit', 'update', 'show']);
    Route::patch('appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])
        ->name('appointments.confirm');
    Route::patch('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])
        ->name('appointments.cancel');

    // Mise à niveau de l'abonnement
    Route::post('/subscription/upgrade', [DashboardController::class, 'upgradeSubscription'])
        ->middleware('auth')
        ->name('subscription.upgrade');
});

Route::get('statistics', [StatisticsController::class, 'index'])
    ->name('statistics.index');

require __DIR__.'/auth.php';