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
        $request->validate([
            'service_id'   => 'required|exists:services,id',
            'date'         => 'required|date|after_or_equal:today',
            'start_time'   => 'required',
            'client_name'  => 'required|string|max:255',
            'client_email' => 'required|email',
            'client_phone' => 'nullable|string|max:20',
        ]);

        $service = Service::findOrFail($request->service_id);
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