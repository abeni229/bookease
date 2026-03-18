<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation confirmée — BookEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        @keyframes scaleIn {
            from { transform: scale(0); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .scale-in { animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
        .fade-up { animation: fadeUp 0.6s ease forwards; }
        .d1 { animation-delay: 0.3s; opacity: 0; }
        .d2 { animation-delay: 0.5s; opacity: 0; }
        .d3 { animation-delay: 0.7s; opacity: 0; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- NAVBAR --}}
    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-2xl mx-auto px-4 h-14 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-[#1E3A8A] rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="font-bold text-gray-900">BookEase</span>
            </div>
        </div>
    </nav>

    <div class="max-w-lg mx-auto px-4 py-12">

        {{-- Icône succès --}}
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 scale-in">
                <svg class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="fade-up d1 text-2xl font-bold text-gray-900 mb-2">Réservation confirmée !</h1>
            <p class="fade-up d2 text-gray-500">Un email de confirmation a été envoyé à <strong>{{ $appointment->client_email }}</strong></p>
        </div>

        {{-- Récapitulatif --}}
        <div class="fade-up d2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
            <div class="bg-[#1E3A8A] px-6 py-4">
                <p class="text-white font-semibold">Détails de votre rendez-vous</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-[#1E3A8A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Client</p>
                        <p class="font-semibold text-gray-900">{{ $appointment->client_name }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-[#1E3A8A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Service</p>
                        <p class="font-semibold text-gray-900">{{ $appointment->service->name }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-[#1E3A8A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Date</p>
                        <p class="font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($appointment->date)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-[#1E3A8A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Heure</p>
                        <p class="font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}
                            — {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
                            ({{ $appointment->service->duration }} min)
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-[#1E3A8A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Professionnel</p>
                        <p class="font-semibold text-gray-900">{{ $appointment->user->name }}</p>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                    <span class="text-sm text-gray-500">Statut</span>
                    <span class="bg-yellow-50 text-yellow-600 border border-yellow-200 text-xs font-medium px-3 py-1 rounded-full">
                        En attente de confirmation
                    </span>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="fade-up d3 space-y-3">
            <a href="{{ route('booking.index', $appointment->user_id) }}"
                class="block w-full text-center bg-[#1E3A8A] hover:bg-[#1D4ED8] text-white font-semibold px-6 py-3.5 rounded-xl transition-all">
                Prendre un autre rendez-vous
            </a>
            <p class="text-center text-xs text-gray-400 pt-2">
                Propulsé par <span class="font-semibold text-[#1E3A8A]">BookEase</span>
            </p>
        </div>

    </div>

</body>
</html>
