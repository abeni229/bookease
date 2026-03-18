<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BookEase') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; }
        .sidebar-link { transition: all 0.15s ease; }
        .sidebar-link:hover { background: #EEF2FF; color: #1E3A8A; }
        .sidebar-link.active { background: #1E3A8A; color: white; }
        .sidebar-link.active svg { color: white; }
    </style>
</head>
<body class="bg-gray-50 antialiased">

<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white border-r border-gray-100 shadow-sm flex-shrink-0 hidden md:flex flex-col">

        {{-- Logo --}}
        <div class="px-6 py-5 border-b border-gray-100">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-[#1E3A8A] flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="font-bold text-gray-900 text-lg">BookEase</span>
            </a>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-1">

            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : 'text-gray-600' }} flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="#" class="sidebar-link text-gray-600 flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Rendez-vous
            </a>

            <a href="{{ route('services.index') }}" ... class="sidebar-link text-gray-600 flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Services
            </a>

            <a href="{{ route('timeslots.index') }}" ... class="sidebar-link text-gray-600 flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Créneaux
            </a>

            <a href="#" class="sidebar-link text-gray-600 flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Statistiques
            </a>

        </nav>

       {{-- User bottom --}}
<div class="px-3 py-4 border-t border-gray-100">

    {{-- Lien paramètres --}}
    <a href="{{ route('profile.edit') }}" class="sidebar-link text-gray-600 flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium mb-1">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        Paramètres
    </a>

    {{-- Profil utilisateur --}}
    <div class="flex items-center gap-3 px-3 py-3 rounded-xl bg-gray-50 border border-gray-100 mt-2">
        <div class="w-9 h-9 bg-[#1E3A8A] rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
            <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" title="Déconnexion"
                class="text-gray-400 hover:text-red-500 transition-colors p-1.5 hover:bg-red-50 rounded-lg">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
        </form>
    </div>
</div>
       
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Top header --}}
        <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between">
            <div>
                @isset($header)
                    {{ $header }}
                @endisset
            </div>
        </header>

        {{-- Page content --}}
        <main class="flex-1 overflow-auto">
            {{ $slot }}
        </main>
    </div>

</div>

</body>
</html>