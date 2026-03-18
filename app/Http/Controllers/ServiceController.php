<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'required|integer|min:5',
            'price'       => 'required|numeric|min:0',
        ]);

        Service::create([
            'user_id'     => auth()->id(),
            'name'        => $request->name,
            'description' => $request->description,
            'duration'    => $request->duration,
            'price'       => $request->price,
            'is_active'   => true,
        ]);

        return redirect()->route('services.index')
            ->with('success', 'Service créé avec succès !');
    }

    public function update(Request $request, Service $service)
    {
        $this->authorize('update', $service);

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'required|integer|min:5',
            'price'       => 'required|numeric|min:0',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')
            ->with('success', 'Service mis à jour !');
    }

    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);
        $service->delete();
        return redirect()->route('services.index')
            ->with('success', 'Service supprimé !');
    }

    public function toggle(Service $service)
    {
        $this->authorize('update', $service);
        $service->update(['is_active' => !$service->is_active]);
        return back()->with('success', 'Statut mis à jour !');
    }
}