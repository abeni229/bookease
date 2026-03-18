<x-app-layout>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .input-field {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            font-size: 14px;
            color: #111827;
            background: #F9FAFB;
            transition: all 0.2s;
            outline: none;
        }
        .input-field:focus {
            border-color: #1E3A8A;
            background: white;
            box-shadow: 0 0 0 3px rgba(30,58,138,0.08);
        }
        .btn-primary {
            background: #1E3A8A; color: white;
            padding: 10px 20px; border-radius: 10px;
            font-size: 14px; font-weight: 600;
            border: none; cursor: pointer; transition: all 0.2s;
        }
        .btn-primary:hover { background: #1D4ED8; transform: translateY(-1px); }
        .modal { display: none; position: fixed; inset: 0; z-index: 50; }
        .modal.open { display: flex; }
        .slot-chip { transition: all 0.15s; }
        .slot-chip:hover { transform: translateY(-1px); }
    </style>
</head>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Mes créneaux</h2>
                <p class="text-sm text-gray-500 mt-0.5">Définissez vos disponibilités hebdomadaires</p>
            </div>
            <button onclick="openModal('modal-create')" class="btn-primary flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter un créneau
            </button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            {{-- Alerts --}}
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('error') }}
            </div>
            @endif

            {{-- Info card --}}
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-[#1E3A8A] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-blue-700">
                    Ces créneaux définissent vos disponibilités chaque semaine. Vos clients pourront réserver uniquement sur les créneaux <strong>actifs</strong>.
                </p>
            </div>

            {{-- Empty state --}}
            @if($slots->isEmpty())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
                <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-[#1E3A8A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="font-semibold text-gray-900 mb-1">Aucun créneau défini</p>
                <p class="text-gray-400 text-sm mb-6">Ajoutez vos créneaux horaires pour que vos clients puissent réserver</p>
                <button onclick="openModal('modal-create')" class="btn-primary">
                    Ajouter mon premier créneau
                </button>
            </div>

            @else

            {{-- Créneaux par jour --}}
            @foreach($days as $dayKey => $dayName)
                @if(isset($slots[$dayKey]))
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#1E3A8A]"></div>
                            <h3 class="font-semibold text-gray-900">{{ $dayName }}</h3>
                            <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">
                                {{ $slots[$dayKey]->count() }} créneau(x)
                            </span>
                        </div>
                    </div>
                    <div class="p-4 flex flex-wrap gap-2">
                        @foreach($slots[$dayKey] as $slot)
                        <div class="slot-chip flex items-center gap-2 px-3 py-2 rounded-xl border text-sm
                            {{ $slot->is_available
                                ? 'bg-white border-gray-200 text-gray-800'
                                : 'bg-gray-50 border-gray-100 text-gray-400' }}">
                            <span class="font-medium">
                                {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                                — {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                            </span>

                            {{-- Toggle --}}
                            <form method="POST" action="{{ route('timeslots.toggle', $slot) }}" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" title="{{ $slot->is_available ? 'Désactiver' : 'Activer' }}"
                                    class="w-4 h-4 rounded-full border-2 transition-all
                                    {{ $slot->is_available ? 'bg-green-400 border-green-400' : 'bg-gray-200 border-gray-300' }}">
                                </button>
                            </form>

                            {{-- Supprimer --}}
                            <form method="POST" action="{{ route('timeslots.destroy', $slot) }}"
                                onsubmit="return confirm('Supprimer ce créneau ?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-300 hover:text-red-400 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach
            @endif

        </div>
    </div>

    {{-- MODAL CRÉER --}}
    <div class="modal" id="modal-create">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('modal-create')"></div>
        <div class="relative m-auto bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-gray-900 text-lg">Ajouter un créneau</h3>
                <button onclick="closeModal('modal-create')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('timeslots.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jour de la semaine *</label>
                    <select name="day_of_week" class="input-field" required>
                        <option value="">Choisissez un jour</option>
                        @foreach($days as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Heure de début *</label>
                        <input type="time" name="start_time" class="input-field" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Heure de fin *</label>
                        <input type="time" name="end_time" class="input-field" required>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 text-xs text-blue-600">
                    💡 Astuce : créez un créneau par heure disponible. Ex: 09:00-09:45, 10:00-10:45...
                </div>

                <button type="submit" class="btn-primary w-full">Ajouter le créneau</button>
            </form>
        </div>
    </div>

<script>
    function openModal(id) { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }
</script>

</x-app-layout>