<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeSlot;


class TimeSlotController extends Controller
{
     
    public function index()
    {
        $days = [
            'monday'    => 'Lundi',
            'tuesday'   => 'Mardi',
            'wednesday' => 'Mercredi',
            'thursday'  => 'Jeudi',
            'friday'    => 'Vendredi',
            'saturday'  => 'Samedi',
            'sunday'    => 'Dimanche',
        ];

        $slots = TimeSlot::where('user_id', auth()->id())
            ->orderByRaw("FIELD(day_of_week, 'monday','tuesday','wednesday','thursday','friday','saturday','sunday')")
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        return view('timeslots.index', compact('slots', 'days'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time'  => 'required',
            'end_time'    => 'required|after:start_time',
        ]);

        // Vérifier si le créneau existe déjà
        $exists = TimeSlot::where('user_id', auth()->id())
            ->where('day_of_week', $request->day_of_week)
            ->where('start_time', $request->start_time)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Ce créneau existe déjà !');
        }

        TimeSlot::create([
            'user_id'      => auth()->id(),
            'day_of_week'  => $request->day_of_week,
            'start_time'   => $request->start_time,
            'end_time'     => $request->end_time,
            'is_available' => true,
        ]);

        return back()->with('success', 'Créneau ajouté !');
    }

 public function destroy(TimeSlot $timeSlot)
{
    if ($timeSlot->user_id !== auth()->id()) {
        abort(403);
    }
    $timeSlot->delete();
    return redirect()->route('timeslots.index')
        ->with('success', 'Créneau supprimé !');
}

public function toggle(TimeSlot $timeSlot)
{
    if ($timeSlot->user_id !== auth()->id()) {
        abort(403);
    }
    $timeSlot->update(['is_available' => !$timeSlot->is_available]);
    return redirect()->route('timeslots.index')
        ->with('success', 'Statut mis à jour !');
}
}