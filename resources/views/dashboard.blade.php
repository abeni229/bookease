<x-app-layout>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .stat-card { transition: all 0.2s ease; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(30,58,138,0.1); }
        .rdv-row { transition: all 0.15s ease; }
        .rdv-row:hover { background: #F8F9FF; }
        .badge-confirmed { background: #DCFCE7; color: #16A34A; }
        .badge-pending { background: #FEF9C3; color: #CA8A04; }
        .badge-cancelled { background: #FEE2E2; color: #DC2626; }
    </style>
</head>

<x-slot name="header">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900">
                Bonjour, {{ auth()->user()->name }} 👋
            </h2>
            <p class="text-sm text-gray-500 mt-0.5">{{ $today }}</p>
        </div>
        <a href="#" class="bg-[#1E3A8A] hover:bg-[#1D4ED8] text-white text-sm font-medium px-4 py-2.5 rounded-lg transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nouveau RDV
        </a>
    </div>
</x-slot>

<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- STATS --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Aujourd'hui</span>
                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#1E3A8A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_today'] }}</p>
                <p class="text-xs text-gray-400 mt-1">RDV du jour</p>
            </div>

            <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">En attente</span>
                    <div class="w-8 h-8 bg-yellow-50 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_pending'] }}</p>
                <p class="text-xs text-gray-400 mt-1">À confirmer</p>
            </div>

            <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Confirmés</span>
                    <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_confirmed'] }}</p>
                <p class="text-xs text-gray-400 mt-1">RDV confirmés</p>
            </div>

            <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Services</span>
                    <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_services'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Services actifs</p>
            </div>

        </div>

        {{-- PROCHAINS RDV --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-900">Prochains rendez-vous</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Les 5 prochains RDV à venir</p>
                </div>
                <a href="#" class="text-[#1E3A8A] hover:text-[#1D4ED8] text-sm font-medium transition-colors">
                    Voir tout →
                </a>
            </div>

            @if($upcoming->isEmpty())
            <div class="px-6 py-16 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-gray-500 font-medium">Aucun rendez-vous à venir</p>
                <p class="text-gray-400 text-sm mt-1">Partagez votre lien de réservation pour recevoir vos premiers RDV</p>
                <a href="#" class="inline-block mt-4 bg-[#1E3A8A] text-white text-sm px-5 py-2.5 rounded-lg hover:bg-[#1D4ED8] transition-all">
                    Partager mon lien
                </a>
            </div>
            @else
            <div class="divide-y divide-gray-50">
                @foreach($upcoming as $rdv)
                <div class="rdv-row px-6 py-4 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        {{-- Avatar initiales --}}
                        <div class="w-10 h-10 bg-[#1E3A8A]/10 rounded-full flex items-center justify-center text-[#1E3A8A] font-semibold text-sm flex-shrink-0">
                            {{ strtoupper(substr($rdv->client_name, 0, 2)) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 text-sm">{{ $rdv->client_name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $rdv->service->name ?? 'Service' }}</p>
                        </div>
                    </div>

                    <div class="hidden sm:flex items-center gap-1.5 text-gray-500">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs">{{ $rdv->date->format('d M Y') }}</span>
                    </div>

                    <div class="hidden sm:flex items-center gap-1.5 text-gray-500">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xs">{{ \Carbon\Carbon::parse($rdv->start_time)->format('H:i') }}</span>
                    </div>

                    <span class="text-xs font-medium px-3 py-1 rounded-full
                        @if($rdv->status === 'confirmed') badge-confirmed
                        @elseif($rdv->status === 'pending') badge-pending
                        @else badge-cancelled @endif">
                        @if($rdv->status === 'confirmed') Confirmé
                        @elseif($rdv->status === 'pending') En attente
                        @else Annulé @endif
                    </span>

                    <div class="flex items-center gap-2">
                        <button class="text-gray-400 hover:text-[#1E3A8A] transition-colors p-1.5 hover:bg-blue-50 rounded-lg">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <button class="text-gray-400 hover:text-red-500 transition-colors p-1.5 hover:bg-red-50 rounded-lg">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- LIEN DE RÉSERVATION --}}
        <div class="bg-[#1E3A8A] rounded-2xl p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h3 class="font-semibold text-white">Votre lien de réservation</h3>
                <p class="text-blue-200 text-sm mt-1">Partagez ce lien à vos clients pour qu'ils réservent directement</p>
            </div>
            <div class="flex items-center gap-2 bg-white/10 border border-white/20 rounded-xl px-4 py-2.5 min-w-0">
                <span class="text-blue-100 text-sm truncate">bookease.app/{{ auth()->user()->id }}</span>
                <button onclick="navigator.clipboard.writeText('bookease.app/{{ auth()->user()->id }}')"
                    class="text-white hover:text-blue-200 flex-shrink-0 transition-colors ml-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>
</x-app-layout>