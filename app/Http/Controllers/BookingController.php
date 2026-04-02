<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\TimeSlot;
use Carbon\Carbon;
use App\Mail\AppointmentConfirmed;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    // Page publique de réservation
    public function index($userId)
    {
        $pro = User::findOrFail($userId);
        $services = Service::where('user_id', $userId)
            ->where('is_active', true)
            ->get();

        return view('booking.index', compact('pro', 'services'));
    }

    // Récupérer les créneaux disponibles pour une date
    public function getSlots(Request $request, $userId)
    {
        $date = Carbon::parse($request->date);
        $dayOfWeek = strtolower($date->englishDayOfWeek);

        $slots = TimeSlot::where('user_id', $userId)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->get();

        $bookedTimes = Appointment::where('user_id', $userId)
            ->whereDate('date', $date)
            ->where('status', '!=', 'cancelled')
            ->pluck('start_time')
            ->toArray();

        $available = $slots->filter(function($slot) use ($bookedTimes) {
            return !in_array($slot->start_time, $bookedTimes);
        })->values();

        return response()->json($available);
    }

    // Enregistrer la réservation
    public function store(Request $request, $userId)
    {
        $validationRules = config('security.validation');

        $request->validate([
            'service_id'   => 'required|exists:services,id',
            'date'         => 'required|date|after_or_equal:today|before_or_equal:' . now()->addDays($validationRules['max_future_booking_days'])->format('Y-m-d'),
            'start_time'   => 'required|date_format:H:i',
            'client_name'  => 'required|string|max:' . $validationRules['max_name_length'] . '|regex:/^[a-zA-ZÀ-ÿ\s\-\'\.]+$/',
            'client_email' => 'required|email:rfc,dns|max:' . $validationRules['max_name_length'],
            'client_phone' => 'nullable|string|max:' . $validationRules['max_phone_length'] . '|regex:/^[\+]?[0-9\s\-\(\)]+$/',
            'timestamp'    => 'required|integer',
        ]);

        // Vérifier que le service appartient bien à l'utilisateur
        $service = Service::where('id', $request->service_id)
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->firstOrFail();

        // Vérifier que le créneau est disponible
        $existingAppointment = Appointment::where('user_id', $userId)
            ->where('date', $request->date)
            ->where('start_time', $request->start_time)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($existingAppointment) {
            return back()->withErrors(['slot' => 'Ce créneau n\'est plus disponible.'])->withInput();
        }

        // Vérifier que le créneau existe dans les disponibilités
        $dayOfWeek = Carbon::parse($request->date)->englishDayOfWeek;
        $timeSlot = TimeSlot::where('user_id', $userId)
            ->where('day_of_week', strtolower($dayOfWeek))
            ->where('start_time', $request->start_time)
            ->where('is_available', true)
            ->first();

        if (!$timeSlot) {
            return back()->withErrors(['slot' => 'Ce créneau n\'est pas disponible.'])->withInput();
        }

        $start = Carbon::parse($request->start_time);
        $end = $start->copy()->addMinutes($service->duration);

        $appointment = Appointment::create([
            'user_id'      => $userId,
            'service_id'   => $request->service_id,
            'client_name'  => $request->client_name,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'date'         => $request->date,
            'start_time'   => $start->format('H:i'),
            'end_time'     => $end->format('H:i'),
            'status'       => 'pending',
        ]);

       // Envoyer email de confirmation
    Mail::to($appointment->client_email)
        ->send(new AppointmentConfirmed($appointment->load(['service', 'user'])));

        return redirect()->route('booking.confirmation', $appointment->id);
    }

    // Page de confirmation
    public function confirmation($appointmentId)
    {
        $appointment = Appointment::with(['service', 'user'])->findOrFail($appointmentId);
        return view('booking.confirmation', compact('appointment'));
    }
}