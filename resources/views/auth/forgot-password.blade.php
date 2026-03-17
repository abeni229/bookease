<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mot de passe oublié — BookEase</title>
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
        .btn-submit {
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
        .btn-submit:hover {
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
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-white leading-tight mb-4">
                Pas de panique,<br>ça arrive à tout le monde
            </h1>
            <p class="text-blue-200 text-lg leading-relaxed">
                Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe en quelques secondes.
            </p>
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

            {{-- Icône --}}
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-7 h-7 text-[#1E3A8A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-1">Mot de passe oublié ?</h2>
            <p class="text-gray-500 text-sm mb-8">
                Entrez votre email et on vous envoie un lien de réinitialisation.
            </p>

            {{-- Status --}}
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
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

                {{-- Submit --}}
                <button type="submit" class="btn-submit">
                    Envoyer le lien de réinitialisation →
                </button>

                {{-- Retour login --}}
                <div class="text-center pt-2">
                    <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-[#1E3A8A] transition-colors flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Retour à la connexion
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>