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
        .btn-save {
            background: #1E3A8A;
            color: white;
            padding: 10px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-save:hover { background: #1D4ED8; transform: translateY(-1px); }
        .inline-block { margin-top: 1.5rem; }
    </style>
</head>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Mon profil</h2>
                <p class="text-sm text-gray-500 mt-0.5">Gérez vos informations personnelles et votre sécurité</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Avatar + nom --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex items-center gap-5">
                <div class="w-16 h-16 bg-[#1E3A8A] rounded-2xl flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div>
                    <p class="font-bold text-gray-900 text-lg">{{ auth()->user()->name }}</p>
                    <p class="text-gray-500 text-sm">{{ auth()->user()->email }}</p>
                    <p class="text-xs text-gray-400 mt-1">Membre depuis {{ auth()->user()->created_at->translatedFormat('F Y') }}</p>
                </div>
            </div>

            {{-- Informations personnelles --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Informations personnelles</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Mettez à jour votre nom et votre adresse email</p>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                        @csrf
                        @method('patch')

                        @if (session('status') === 'profile-updated')
                            <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Profil mis à jour avec succès !
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nom complet</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                    class="input-field @error('name') border-red-400 @enderror" required>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Adresse email</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                    class="input-field @error('email') border-red-400 @enderror" required>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="btn-save">Enregistrer les modifications</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Changer mot de passe --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Changer le mot de passe</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Utilisez un mot de passe long et aléatoire pour sécuriser votre compte</p>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                        @csrf
                        @method('put')

                        @if (session('status') === 'password-updated')
                            <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Mot de passe mis à jour avec succès !
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Mot de passe actuel</label>
                            <input type="password" name="current_password"
                                class="input-field @error('current_password') border-red-400 @enderror"
                                placeholder="••••••••">
                            @error('current_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nouveau mot de passe</label>
                                <input type="password" name="password"
                                    class="input-field @error('password') border-red-400 @enderror"
                                    placeholder="Minimum 8 caractères">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirmer le mot de passe</label>
                                <input type="password" name="password_confirmation"
                                    class="input-field"
                                    placeholder="Répétez le mot de passe">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="btn-save">Mettre à jour le mot de passe</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Supprimer le compte --}}
            <div class="bg-white rounded-2xl border border-red-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-red-100 bg-red-50/50">
                    <h3 class="font-semibold text-red-700">Zone dangereuse</h3>
                    <p class="text-xs text-red-400 mt-0.5">Ces actions sont irréversibles — procédez avec prudence</p>
                </div>
                <div class="p-6 flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900 text-sm">Supprimer mon compte</p>
                        <p class="text-xs text-gray-500 mt-0.5">Toutes vos données seront définitivement supprimées</p>
                    </div>
                    <form method="POST" action="{{ route('profile.destroy') }}"
                        onsubmit="return confirm('Êtes-vous sûr ? Cette action est irréversible.')">
                        @csrf
                        @method('delete')
                        <input type="password" name="password" placeholder="Votre mot de passe"
                            class="input-field w-48 mr-3 inline-block" required>
                            <div class="inline-block">
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition-all">
                            Supprimer
                        </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>