<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Appointment;
 

class AppointmentController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
       
        $query = Appointment::where('user_id', auth()->id())
            ->with('service')
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc');

        // Filtres
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->date) {
            $query->whereDate('date', $request->date);
        }
        if ($request->search) {
            $query->where('client_name', 'like', '%'.$request->search.'%')
                  ->orWhere('client_email', 'like', '%'.$request->search.'%');
        }

        $appointments = $query->paginate(10);

        $stats = [
            'total'     => Appointment::where('user_id', auth()->id())->count(),
            'pending'   => Appointment::where('user_id', auth()->id())->where('status', 'pending')->count(),
            'confirmed' => Appointment::where('user_id', auth()->id())->where('status', 'confirmed')->count(),
            'cancelled' => Appointment::where('user_id', auth()->id())->where('status', 'cancelled')->count(),
        ];

        return view('appointments.index', compact('appointments', 'stats'));
    }

    public function confirm(Appointment $appointment)
    {
        $this->authorize('update', $appointment);
        $appointment->update(['status' => 'confirmed']);
        return back()->with('success', 'Rendez-vous confirmé !');
    }

    public function cancel(Appointment $appointment)
    {
        $this->authorize('update', $appointment);
        $appointment->update(['status' => 'cancelled']);
        return back()->with('success', 'Rendez-vous annulé.');
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);
        $appointment->delete();
        return back()->with('success', 'Rendez-vous supprimé !');
    }
}