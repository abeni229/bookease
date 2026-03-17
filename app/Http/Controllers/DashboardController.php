<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Service;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_today'    => Appointment::where('user_id', $user->id)->today()->count(),
            'total_pending'  => Appointment::where('user_id', $user->id)->pending()->count(),
            'total_confirmed'=> Appointment::where('user_id', $user->id)->confirmed()->count(),
            'total_services' => Service::where('user_id', $user->id)->count(),
        ];

        $upcoming = Appointment::where('user_id', $user->id)
            ->whereDate('date', '>=', today())
            ->where('status', '!=', 'cancelled')
            ->with('service')
            ->orderBy('date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

          Carbon::setLocale('fr');
            $today = Carbon::now()->isoFormat('dddd D MMMM YYYY');
            return view('dashboard', compact('stats', 'upcoming', 'today'));
    }
}