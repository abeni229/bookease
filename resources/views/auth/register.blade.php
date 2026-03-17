<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Créer un compte — BookEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .bg-split { background: linear-gradient(135deg, #1E3A8A 0%, #1D4ED8 100%); }
        .input-field {
            width: 100%;
            padding: 12px 16px;
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
        .btn-register {
            background: #1E3A8A;
            color: white;
            width: 100%;
            padding: 13px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-register:hover {
            background: #1D4ED8;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(30,58,138,0.35);
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.6s ease forwards; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex">

    {{-- GAUCHE — Branding --}}
    <div class="hidden lg:flex lg:w-1/2 bg-split flex-col justify-between p-12">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="text-white font-bold text-xl">BookEase</span>
        </div>

        <div>
            <h1 class="text-4xl font-bold text-white leading-tight mb-4">
                Rejoignez des centaines<br>de professionnels
            </h1>
            <p class="text-blue-200 text-lg leading-relaxed mb-10">
                Créez votre espace en 2 minutes et commencez à recevoir des réservations dès aujourd'hui.
            </p>

            {{-- Avantages --}}
            <div class="space-y-4">
                @foreach([
                    ['✓', 'Gratuit pour commencer — sans carte bancaire'],
                    ['✓', 'Lien de réservation personnalisé immédiat'],
                    ['✓', 'Confirmations email automatiques'],
                    ['✓', 'Dashboard pro inclus'],
                ] as [$icon, $text])
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">{{ $icon }}</div>
                    <span class="text-blue-100 text-sm">{{ $text }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <p class="text-blue-300 text-xs">© 2025 BookEase. Tous droits réservés.</p>
    </div>

    {{-- DROITE — Formulaire --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 overflow-y-auto">
        <div class="w-full max-w-md fade-up py-8">

            {{-- Logo mobile --}}
            <div class="flex items-center gap-2 mb-8 lg:hidden">
                <div class="w-8 h-8 bg-[#1E3A8A] rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="font-bold text-gray-900 text-lg">BookEase</span>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-1">Créer votre compte 🚀</h2>
            <p class="text-gray-500 text-sm mb-8">Gratuit · Sans carte bancaire · Prêt en 2 minutes</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Nom --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nom complet</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="input-field @error('name') border-red-400 @enderror"
                        placeholder="Ex: Jean Dupont" required autofocus>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Adresse email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="input-field @error('email') border-red-400 @enderror"
                        placeholder="vous@exemple.com" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Mot de passe</label>
                    <input type="password" name="password"
                        class="input-field @error('password') border-red-400 @enderror"
                        placeholder="Minimum 8 caractères" required>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmation --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation"
                        class="input-field"
                        placeholder="Répétez votre mot de passe" required>
                </div>

                {{-- CGU --}}
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-xs text-gray-500 leading-relaxed">
                    En créant un compte, vous acceptez nos
                    <a href="#" class="text-[#1E3A8A] font-medium hover:underline">Conditions d'utilisation</a>
                    et notre
                    <a href="#" class="text-[#1E3A8A] font-medium hover:underline">Politique de confidentialité</a>.
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-register">
                    Créer mon compte gratuit →
                </button>

                {{-- Login link --}}
                <p class="text-center text-sm text-gray-500 pt-2">
                    Déjà un compte ?
                    <a href="{{ route('login') }}" class="text-[#1E3A8A] font-semibold hover:text-[#1D4ED8] transition-colors">
                        Se connecter
                    </a>
                </p>
            </form>
        </div>
    </div>

</body>
</html>