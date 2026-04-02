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
        $validationRules = config('security.validation');

        $request->validate([
            'name'        => 'required|string|max:' . $validationRules['max_name_length'] . '|regex:/^[a-zA-ZÀ-ÿ0-9\s\-\'\.\,\(\)]+$/',
            'description' => 'nullable|string|max:' . $validationRules['max_description_length'],
            'duration'    => 'required|integer|min:' . $validationRules['min_duration'] . '|max:' . $validationRules['max_duration'],
            'price'       => 'required|numeric|min:0|max:' . $validationRules['max_price'],
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

        $validationRules = config('security.validation');

        $request->validate([
            'name'        => 'required|string|max:' . $validationRules['max_name_length'] . '|regex:/^[a-zA-ZÀ-ÿ0-9\s\-\'\.\,\(\)]+$/',
            'description' => 'nullable|string|max:' . $validationRules['max_description_length'],
            'duration'    => 'required|integer|min:' . $validationRules['min_duration'] . '|max:' . $validationRules['max_duration'],
            'price'       => 'required|numeric|min:0|max:' . $validationRules['max_price'],
        ]);

        $service->update($request->only(['name', 'description', 'duration', 'price']));

        return redirect()->route('services.index')
            ->with('success', 'Service mis à jour !');
    }

    public function destroy(Service $service)
    {
       if ($service->user_id !== auth()->id()) {
    abort(403);
}
        $service->delete();
        return redirect()->route('services.index')
            ->with('success', 'Service supprimé !');
    }

    public function toggle(Service $service)
    {
        if ($service->user_id !== auth()->id()) {
    abort(403);
}
        $service->update(['is_active' => !$service->is_active]);
        return back()->with('success', 'Statut mis à jour !');
    }
}