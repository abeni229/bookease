<x-app-layout>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .input-field {
            padding: 9px 14px;
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
        .badge-confirmed { background: #DCFCE7; color: #16A34A; border: 1px solid #BBF7D0; }
        .badge-pending   { background: #FEF9C3; color: #CA8A04; border: 1px solid #FDE68A; }
        .badge-cancelled { background: #FEE2E2; color: #DC2626; border: 1px solid #FECACA; }
        .rdv-row { transition: all 0.15s; }
        .rdv-row:hover { background: #F8FAFF; }
    </style>
</head>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Mes rendez-vous</h2>
                <p class="text-sm text-gray-500 mt-0.5">Gérez et suivez tous vos rendez-vous</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Alerts --}}
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            {{-- Stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Total</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-yellow-500">{{ $stats['pending'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">En attente</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-green-500">{{ $stats['confirmed'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Confirmés</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-red-400">{{ $stats['cancelled'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Annulés</p>
                </div>
            </div>

            {{-- Filtres --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
                <form method="GET" action="{{ route('appointments.index') }}" class="flex flex-wrap gap-3">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="input-field flex-1 min-w-40"
                        placeholder="Rechercher un client...">
                    <input type="date" name="date" value="{{ request('date') }}"
                        class="input-field">
                    <select name="status" class="input-field">
                        <option value="">Tous les statuts</option>
                        <option value="pending"   {{ request('status') === 'pending'    ? 'selected' : '' }}>En attente</option>
                        <option value="confirmed" {{ request('status') === 'confirmed'  ? 'selected' : '' }}>Confirmés</option>
                        <option value="cancelled" {{ request('status') === 'cancelled'  ? 'selected' : '' }}>Annulés</option>
                    </select>
                    <button type="submit" class="bg-[#1E3A8A] text-white px-5 py-2 rounded-xl text-sm font-medium hover:bg-[#1D4ED8] transition-all">
                        Filtrer
                    </button>
                    @if(request()->hasAny(['search','date','status']))
                    <a href="{{ route('appointments.index') }}" class="text-gray-400 hover:text-gray-600 px-3 py-2 rounded-xl text-sm transition-colors">
                        Réinitialiser
                    </a>
                    @endif
                </form>
            </div>

            {{-- Liste --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                @if($appointments->isEmpty())
                <div class="text-center py-16">
                    <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium">Aucun rendez-vous trouvé</p>
                    <p class="text-gray-400 text-sm mt-1">
                        @if(request()->hasAny(['search','date','status']))
                            Essayez d'autres filtres
                        @else
                            Partagez votre lien de réservation pour recevoir vos premiers RDV
                        @endif
                    </p>
                </div>

                @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50">
                                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Client</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Service</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Date</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Heure</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Statut</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($appointments as $rdv)
                            <tr class="rdv-row">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-[#1E3A8A]/10 rounded-full flex items-center justify-center text-[#1E3A8A] font-semibold text-xs flex-shrink-0">
                                            {{ strtoupper(substr($rdv->client_name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 text-sm">{{ $rdv->client_name }}</p>
                                            <p class="text-xs text-gray-400">{{ $rdv->client_email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm text-gray-700">{{ $rdv->service->name ?? '—' }}</p>
                                    <p class="text-xs text-gray-400">{{ $rdv->service->duration ?? '' }} min</p>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($rdv->date)->locale('fr')->isoFormat('ddd D MMM YYYY') }}
                                    </p>
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($rdv->start_time)->format('H:i') }}
                                    </p>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="text-xs font-medium px-3 py-1 rounded-full
                                        @if($rdv->status === 'confirmed') badge-confirmed
                                        @elseif($rdv->status === 'pending') badge-pending
                                        @else badge-cancelled @endif">
                                        @if($rdv->status === 'confirmed') Confirmé
                                        @elseif($rdv->status === 'pending') En attente
                                        @else Annulé @endif
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-1">
                                        {{-- Confirmer --}}
                                        @if($rdv->status === 'pending')
                                        <form method="POST" action="{{ route('appointments.confirm', $rdv) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" title="Confirmer"
                                                class="p-1.5 text-green-500 hover:bg-green-50 rounded-lg transition-all">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </button>
                                        </form>
                                        @endif

                                        {{-- Annuler --}}
                                        @if($rdv->status !== 'cancelled')
                                        <form method="POST" action="{{ route('appointments.cancel', $rdv) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" title="Annuler"
                                                class="p-1.5 text-yellow-500 hover:bg-yellow-50 rounded-lg transition-all">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                </svg>
                                            </button>
                                        </form>
                                        @endif

                                        {{-- Supprimer --}}
                                        <form method="POST" action="{{ route('appointments.destroy', $rdv) }}"
                                            onsubmit="return confirm('Supprimer ce rendez-vous ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" title="Supprimer"
                                                class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($appointments->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $appointments->withQueryString()->links() }}
                </div>
                @endif
                @endif
            </div>

        </div>
    </div>

</x-app-layout>