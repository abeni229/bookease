<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion — BookEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .bg-split {
            background: linear-gradient(135deg, #1E3A8A 0%, #1D4ED8 100%);
        }
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
        .btn-login {
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
        .btn-login:hover {
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
                Gérez vos rendez-vous<br>comme un pro
            </h1>
            <p class="text-blue-200 text-lg leading-relaxed mb-10">
                La plateforme pensée pour les professionnels africains qui veulent moderniser leur business.
            </p>

            {{-- Témoignage --}}
            <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6">
                <p class="text-white text-sm leading-relaxed italic mb-4">
                    "BookEase a transformé ma façon de gérer mon salon. Plus de WhatsApp à n'en plus finir, mes clients réservent seuls !"
                </p>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center text-white font-semibold text-sm">AM</div>
                    <div>
                        <p class="text-white text-sm font-medium">Aminata M.</p>
                        <p class="text-blue-200 text-xs">Salon de coiffure, Cotonou</p>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-blue-300 text-xs">© 2025 BookEase. Tous droits réservés.</p>
    </div>

    {{-- DROITE — Formulaire --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6">
        <div class="w-full max-w-md fade-up">

            {{-- Logo mobile --}}
            <div class="flex items-center gap-2 mb-8 lg:hidden">
                <div class="w-8 h-8 bg-[#1E3A8A] rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="font-bold text-gray-900 text-lg">BookEase</span>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-1">Bon retour 👋</h2>
            <p class="text-gray-500 text-sm mb-8">Connectez-vous à votre espace BookEase</p>

            {{-- Session status --}}
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-6">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Adresse email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="input-field @error('email') border-red-400 @enderror"
                        placeholder="vous@exemple.com" required autofocus>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-sm font-medium text-gray-700">Mot de passe</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-[#1E3A8A] hover:text-[#1D4ED8] font-medium transition-colors">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>
                    <input type="password" name="password"
                        class="input-field @error('password') border-red-400 @enderror"
                        placeholder="••••••••" required>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="remember" name="remember"
                        class="w-4 h-4 rounded border-gray-300 text-[#1E3A8A] focus:ring-[#1E3A8A]">
                    <label for="remember" class="text-sm text-gray-600">Se souvenir de moi</label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-login">
                    Se connecter →
                </button>

                {{-- Register link --}}
                <p class="text-center text-sm text-gray-500 pt-2">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="text-[#1E3A8A] font-semibold hover:text-[#1D4ED8] transition-colors">
                        Créer un compte gratuit
                    </a>
                </p>
            </form>
        </div>
    </div>

</body>
</html>