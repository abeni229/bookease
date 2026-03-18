<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Carbon\Carbon;
use App\Models\Appointment;


class StatisticsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Stats globales
        $stats = [
            'total'     => Appointment::where('user_id', $user->id)->count(),
            'confirmed' => Appointment::where('user_id', $user->id)->where('status', 'confirmed')->count(),
            'cancelled' => Appointment::where('user_id', $user->id)->where('status', 'cancelled')->count(),
            'pending'   => Appointment::where('user_id', $user->id)->where('status', 'pending')->count(),
        ];

        // RDV des 7 derniers jours
        $last7days = collect(range(6, 0))->map(function($i) use ($user) {
            $date = Carbon::today()->subDays($i);
            return [
                'date'  => $date->locale('fr')->isoFormat('ddd D'),
                'count' => Appointment::where('user_id', $user->id)
                    ->whereDate('date', $date)
                    ->count(),
            ];
        });

        // Service le plus populaire
        $topService = Service::where('user_id', $user->id)
            ->withCount('appointments')
            ->orderBy('appointments_count', 'desc')
            ->first();

        // RDV ce mois
        $thisMonth = Appointment::where('user_id', $user->id)
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->count();

        // RDV mois dernier
        $lastMonth = Appointment::where('user_id', $user->id)
            ->whereMonth('date', Carbon::now()->subMonth()->month)
            ->whereYear('date', Carbon::now()->subMonth()->year)
            ->count();

        return view('statistics.index', compact(
            'stats', 'last7days', 'topService', 'thisMonth', 'lastMonth'
        ));
    }
    public function appointments()
{
    return $this->hasMany(Appointment::class);
}
}