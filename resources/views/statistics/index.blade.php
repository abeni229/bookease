<x-app-layout>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .stat-card { transition: all 0.2s ease; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(30,58,138,0.1); }
    </style>
</head>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Statistiques</h2>
            <p class="text-sm text-gray-500 mt-0.5">Vue d'ensemble de votre activité</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Stats globales --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="stat-card bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total</span>
                        <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#1E3A8A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Rendez-vous</p>
                </div>

                <div class="stat-card bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Confirmés</span>
                        <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['confirmed'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">RDV confirmés</p>
                </div>

                <div class="stat-card bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Ce mois</span>
                        <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-purple-600">{{ $thisMonth }}</p>
                    <div class="flex items-center gap-1 mt-1">
                        @if($thisMonth >= $lastMonth)
                        <span class="text-xs text-green-500">↑</span>
                        @else
                        <span class="text-xs text-red-400">↓</span>
                        @endif
                        <p class="text-xs text-gray-400">vs {{ $lastMonth }} le mois dernier</p>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Annulés</span>
                        <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-red-400">{{ $stats['cancelled'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">RDV annulés</p>
                </div>
            </div>

            {{-- Graphique + Top service --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Graphique 7 jours --}}
                <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="font-semibold text-gray-900">Activité des 7 derniers jours</h3>
                            <p class="text-xs text-gray-400 mt-0.5">Nombre de rendez-vous par jour</p>
                        </div>
                    </div>
                    <canvas id="activityChart" height="120"></canvas>
                </div>

                {{-- Top service + statuts --}}
                <div class="space-y-4">

                    {{-- Service populaire --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                        <h3 class="font-semibold text-gray-900 mb-4">Service le plus populaire</h3>
                        @if($topService)
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-[#1E3A8A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $topService->name }}</p>
                                <p class="text-xs text-gray-400">{{ $topService->appointments_count }} réservation(s)</p>
                            </div>
                        </div>
                        @else
                        <p class="text-gray-400 text-sm">Aucun service encore</p>
                        @endif
                    </div>

                    {{-- Répartition statuts --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                        <h3 class="font-semibold text-gray-900 mb-4">Répartition des statuts</h3>
                        @if($stats['total'] > 0)
                        <canvas id="statusChart" height="160"></canvas>
                        @else
                        <p class="text-gray-400 text-sm text-center py-4">Pas encore de données</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

<script>
    // Graphique activité 7 jours
    const activityCtx = document.getElementById('activityChart').getContext('2d');
    new Chart(activityCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($last7days->pluck('date')) !!},
            datasets: [{
                label: 'Rendez-vous',
                data: {!! json_encode($last7days->pluck('count')) !!},
                backgroundColor: 'rgba(30, 58, 138, 0.15)',
                borderColor: '#1E3A8A',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    @if($stats['total'] > 0)
    // Graphique statuts
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Confirmés', 'En attente', 'Annulés'],
            datasets: [{
                data: [{{ $stats['confirmed'] }}, {{ $stats['pending'] }}, {{ $stats['cancelled'] }}],
                backgroundColor: ['#22C55E', '#F59E0B', '#EF4444'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 12 }, padding: 12 }
                }
            },
            cutout: '65%'
        }
    });
    @endif
</script>

</x-app-layout>