<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookEase — Simplifiez vos rendez-vous</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        html { scroll-behavior: smooth; }

        .hero-bg {
            background-image:
                linear-gradient(rgba(255,255,255,0.82), rgba(255,255,255,0.82)),
                url('https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=1600&q=80&fit=crop');
            background-size: cover;
            background-position: center;
        }

        .btn-primary {
            background: #1E3A8A;
            color: white;
            transition: all 0.2s;
        }
        .btn-primary:hover {
            background: #0055CC;
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(0,107,255,0.35);
        }

        .card {
            transition: all 0.2s ease;
            border: 1px solid #F0F0F0;
        }
        .card:hover {
            border-color:#1E3A8A;
            box-shadow: 0 8px 30px rgba(0,107,255,0.1);
            transform: translateY(-3px);
        }

        .step-line {
            background: linear-gradient(90deg, #1E3A8A, #7B61FF);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .float { animation: float 4s ease-in-out infinite; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.7s ease forwards; }
        .d1 { animation-delay: 0.1s; opacity: 0; }
        .d2 { animation-delay: 0.25s; opacity: 0; }
        .d3 { animation-delay: 0.4s; opacity: 0; }
        .d4 { animation-delay: 0.55s; opacity: 0; }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">

{{-- NAVBAR --}}
<nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-sm border-b border-gray-100">
    <div class="w-full max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">

        {{-- Logo --}}
        <a href="/" class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-[#006BFF] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="font-bold text-lg tracking-tight text-gray-900">BookEase</span>
        </a>

        {{-- Links --}}
        <div class="hidden md:flex items-center gap-8">
            <a href="#features" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">Fonctionnalités</a>
            <a href="#how" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">Comment ça marche</a>
            <a href="#pricing" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">Tarifs</a>
        </div>

        {{-- Auth --}}
        <div class="flex items-center gap-3">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors">Mon espace →</a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">Connexion</a>
                <a href="{{ route('register') }}" class="btn-primary text-sm font-medium px-5 py-2.5 rounded-lg">
                    Essayer gratuitement
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- HERO --}}
<section class="hero-bg">
    <div class="max-w-5xl mx-auto px-6 pt-24 pb-20 text-center">

        {{-- Badge --}}
        <div class="fade-up d1 inline-flex items-center gap-2 bg-blue-50 text-blue-600 text-xs font-medium px-4 py-1.5 rounded-full mb-8 border border-blue-100">
            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
            Nouveau — Confirmations automatiques par email
        </div>

        {{-- Titre --}}
        <h1 class="fade-up d2 text-5xl md:text-6xl font-extrabold text-gray-900 leading-[1.15] tracking-tight mb-6">
            Planifiez vos rendez-vous.<br>
            <span class="text-[#006BFF]">Automatiquement.</span>
        </h1>

        {{-- Sous-titre --}}
        <p class="fade-up d3 text-xl text-gray-500 max-w-2xl mx-auto mb-10 leading-relaxed font-light">
            BookEase élimine les échanges interminables sur WhatsApp.
            Partagez votre lien — vos clients réservent en 30 secondes.
        </p>

        {{-- CTAs --}}
        <div class="fade-up d4 flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
            <a href="{{ route('register') }}" class="btn-primary px-7 py-3.5 rounded-xl font-semibold text-base w-full sm:w-auto text-center">
                Commencer gratuitement →
            </a>
            <a href="#how" class="text-gray-600 hover:text-gray-900 text-base font-medium flex items-center gap-2 transition-colors">
                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Voir la démo
            </a>
        </div>

        {{-- UI Preview Card --}}
        <div class="fade-up d4 float max-w-md mx-auto bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden text-left">
            <div class="bg-[#006BFF] px-5 py-4">
                <p class="text-white font-semibold text-sm">Choisissez un créneau</p>
                <p class="text-blue-200 text-xs mt-0.5">Mardi 21 Janvier 2025</p>
            </div>
            <div class="p-4 grid grid-cols-3 gap-2">
                @foreach(['09:00','09:30','10:00','10:30','11:00','11:30'] as $i => $time)
                <div class="text-center py-2 rounded-lg text-sm font-medium {{ $i === 2 ? 'bg-[#006BFF] text-white' : 'bg-gray-50 text-gray-700 hover:bg-blue-50 cursor-pointer' }}">
                    {{ $time }}
                </div>
                @endforeach
            </div>
            <div class="px-4 pb-4">
                <div class="bg-blue-50 rounded-xl p-3 flex items-center gap-3 border border-blue-100">
                    <div class="w-8 h-8 bg-[#006BFF] rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">JD</div>
                    <div>
                        <p class="text-gray-900 text-sm font-medium">Jean Dupont</p>
                        <p class="text-gray-500 text-xs">10:00 · 30 min confirmé ✓</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- LOGOS / SOCIAL PROOF --}}
<section class="border-y border-gray-100 py-8 bg-gray-50">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <p class="text-xs text-gray-400 uppercase tracking-widest font-medium mb-6">Utilisé par des professionnels au Bénin et en Afrique</p>
        <div class="flex justify-center gap-12 flex-wrap">
            @foreach(['Médecins','Coiffeurs','Coachs','Avocats','Consultants'] as $pro)
            <span class="text-gray-400 text-sm font-medium">{{ $pro }}</span>
            @endforeach
        </div>
    </div>
</section>

{{-- FEATURES --}}
<section id="features" class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">
                Tout ce dont vous avez besoin
            </h2>
            <p class="text-gray-500 text-lg max-w-xl mx-auto font-light">
                Simple pour vos clients, puissant pour vous.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['🗓️', 'Agenda en temps réel', 'Vos créneaux se mettent à jour automatiquement. Zéro double réservation.'],
                ['📱', 'Mobile first', 'Vos clients réservent en 3 clics depuis leur smartphone, n\'importe où.'],
                ['✉️', 'Rappels automatiques', 'Emails et rappels envoyés automatiquement pour réduire les absences.'],
                ['📈', 'Tableau de bord', 'Visualisez vos statistiques et gérez tous vos RDV en un seul endroit.'],
            ] as [$icon, $title, $desc])
            <div class="card bg-white rounded-2xl p-6">
                <div class="text-3xl mb-4">{{ $icon }}</div>
                <h3 class="font-semibold text-gray-900 mb-2 text-base">{{ $title }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- HOW IT WORKS --}}
<section id="how" class="py-24 bg-gray-50">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">Opérationnel en 3 étapes</h2>
            <p class="text-gray-500 text-lg font-light">Moins de 5 minutes pour commencer</p>
        </div>

        <div class="space-y-6">
            @foreach([
                ['01', 'Créez votre espace gratuit', 'Inscrivez-vous, configurez vos services, vos horaires et vos disponibilités en quelques clics.', 'bg-blue-50 text-blue-600'],
                ['02', 'Partagez votre lien unique', 'Envoyez votre lien de réservation personnalisé à vos clients par WhatsApp, email ou sur votre page Facebook.', 'bg-purple-50 text-purple-600'],
                ['03', 'Recevez et gérez vos RDV', 'Vos clients réservent, vous recevez une notification. Tout est dans votre dashboard, clair et organisé.', 'bg-green-50 text-green-600'],
            ] as [$num, $title, $desc, $color])
            <div class="flex items-start gap-6 bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="w-12 h-12 rounded-xl {{ $color }} flex items-center justify-center font-bold text-lg flex-shrink-0">
                    {{ $num }}
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-1 text-base">{{ $title }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- TARIFS --}}
<section id="pricing" class="py-24 bg-white">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">
                Tarifs simples et transparents
            </h2>
            <p class="text-gray-500 text-lg font-light">Commencez gratuitement, évoluez selon vos besoins</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Gratuit --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-8">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Gratuit</p>
                <div class="flex items-baseline gap-1 mb-6">
                    <span class="text-4xl font-extrabold text-gray-900">0</span>
                    <span class="text-gray-500">FCFA/mois</span>
                </div>
                <ul class="space-y-3 mb-8">
                    @foreach(['1 service', '10 RDV/mois', 'Page de réservation', 'Emails de confirmation', 'Dashboard basique'] as $feature)
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $feature }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('register') }}" class="block w-full text-center border border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold px-6 py-3 rounded-xl transition-all text-sm">
                    Commencer gratuitement
                </a>
            </div>

            {{-- Pro -- recommandé --}}
            <div class="bg-[#1E3A8A] rounded-2xl p-8 relative shadow-xl">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                    <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-4 py-1 rounded-full">
                        Recommandé
                    </span>
                </div>
                <p class="text-sm font-semibold text-blue-300 uppercase tracking-wide mb-2">Pro</p>
                <div class="flex items-baseline gap-1 mb-6">
                    <span class="text-4xl font-extrabold text-white">5 000</span>
                    <span class="text-blue-300">FCFA/mois</span>
                </div>
                <ul class="space-y-3 mb-8">
                    @foreach(['Services illimités', 'RDV illimités', 'Page de réservation', 'Emails automatiques', 'Dashboard complet', 'Statistiques avancées', 'Support prioritaire'] as $feature)
                    <li class="flex items-center gap-2 text-sm text-blue-100">
                        <svg class="w-4 h-4 text-yellow-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $feature }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('register') }}" class="block w-full text-center bg-white text-[#1E3A8A] hover:bg-blue-50 font-bold px-6 py-3 rounded-xl transition-all text-sm">
                    Essayer 30 jours gratuit
                </a>
            </div>

            {{-- Entreprise --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-8">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Entreprise</p>
                <div class="flex items-baseline gap-1 mb-6">
                    <span class="text-4xl font-extrabold text-gray-900">Sur devis</span>
                </div>
                <ul class="space-y-3 mb-8">
                    @foreach(['Multi-utilisateurs', 'Domaine personnalisé', 'Intégrations sur mesure', 'API dédiée', 'Support 24/7', 'Formation incluse', 'SLA garanti'] as $feature)
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $feature }}
                    </li>
                    @endforeach
                </ul>
                <a href="#contact" class="block w-full text-center border border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold px-6 py-3 rounded-xl transition-all text-sm">
                    Nous contacter
                </a>
            </div>

        </div>
    </div>
</section>

{{-- CTA FINAL --}}
<section class="py-24 bg-[#006BFF]">
    <div class="max-w-3xl mx-auto px-6 text-center">
        <h2 class="text-4xl font-extrabold text-white mb-4 tracking-tight leading-tight">
            Prêt à simplifier<br>votre quotidien ?
        </h2>
        <p class="text-blue-200 text-lg mb-8 font-light">
            Rejoignez les professionnels qui ont dit adieu aux WhatsApp à n'en plus finir.
        </p>
        <a href="{{ route('register') }}" class="inline-block bg-white text-[#006BFF] font-bold px-8 py-4 rounded-xl hover:bg-gray-50 transition-all text-base hover:shadow-lg">
            Créer mon espace gratuit →
        </a>
        <p class="text-blue-300 text-sm mt-4">Gratuit · Sans carte bancaire · Prêt en 2 minutes</p>
    </div>
</section>

{{-- FOOTER --}}
<footer id="contact" class="bg-gray-900 py-12">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex flex-col md:flex-row items-start justify-between gap-8 mb-10">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-7 h-7 rounded-lg bg-[#006BFF] flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="font-bold text-white">BookEase</span>
                </div>
                <p class="text-gray-400 text-sm max-w-xs leading-relaxed">La plateforme de réservation en ligne pensée pour les professionnels africains.</p>
            </div>
            <div class="flex gap-16">
                <div>
                    <p class="text-gray-300 font-medium text-sm mb-3">Produit</p>
                    <div class="space-y-2">
                        <a href="#features" class="block text-gray-500 hover:text-gray-300 text-sm transition-colors">Fonctionnalités</a>
                        <a href="#how" class="block text-gray-500 hover:text-gray-300 text-sm transition-colors">Comment ça marche</a>
                        <a href="#" class="block text-gray-500 hover:text-gray-300 text-sm transition-colors">Tarifs</a>
                    </div>
                </div>
                <div>
                    <p class="text-gray-300 font-medium text-sm mb-3">Légal</p>
                    <div class="space-y-2">
                        <a href="#" class="block text-gray-500 hover:text-gray-300 text-sm transition-colors">Confidentialité</a>
                        <a href="#" class="block text-gray-500 hover:text-gray-300 text-sm transition-colors">Conditions</a>
                        <a href="#" class="block text-gray-500 hover:text-gray-300 text-sm transition-colors">Contact</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-800 pt-6">
            <p class="text-gray-600 text-sm">© 2025 BookEase. Tous droits réservés.</p>
        </div>
    </div>
</footer>

</body>
</html>