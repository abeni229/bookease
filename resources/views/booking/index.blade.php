<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver avec {{ $pro->name }} — BookEase</title>
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
        .step { display: none; }
        .step.active { display: block; }
        .service-card { cursor: pointer; transition: all 0.2s; border: 2px solid #E5E7EB; }
        .service-card:hover { border-color: #1E3A8A; background: #F0F4FF; }
        .service-card.selected { border-color: #1E3A8A; background: #EEF2FF; }
        .slot-btn { transition: all 0.15s; border: 1.5px solid #E5E7EB; }
        .slot-btn:hover { border-color: #1E3A8A; background: #EEF2FF; color: #1E3A8A; }
        .slot-btn.selected { background: #1E3A8A; color: white; border-color: #1E3A8A; }
        .slot-btn.booked { background: #F3F4F6; color: #9CA3AF; cursor: not-allowed; border-color: #E5E7EB; }
        .btn-primary {
            background: #1E3A8A; color: white;
            padding: 12px 28px; border-radius: 10px;
            font-size: 15px; font-weight: 600;
            border: none; cursor: pointer; transition: all 0.2s;
        }
        .btn-primary:hover { background: #1D4ED8; transform: translateY(-1px); box-shadow: 0 8px 20px rgba(30,58,138,0.3); }
        .btn-primary:disabled { background: #9CA3AF; cursor: not-allowed; transform: none; box-shadow: none; }
        .progress-step { transition: all 0.3s; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.4s ease forwards; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- HEADER --}}
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-2xl mx-auto px-4 h-14 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-[#1E3A8A] rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="font-bold text-gray-900">BookEase</span>
            </div>
            <span class="text-xs text-gray-400">Réservation sécurisée</span>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto px-4 py-8">

        {{-- PROFIL DU PRO --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6 flex items-center gap-4">
            <div class="w-14 h-14 bg-[#1E3A8A] rounded-2xl flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                {{ strtoupper(substr($pro->name, 0, 2)) }}
            </div>
            <div>
                <h1 class="font-bold text-gray-900 text-lg">{{ $pro->name }}</h1>
                <p class="text-gray-500 text-sm">Réservez votre rendez-vous en ligne</p>
                <div class="flex items-center gap-1 mt-1">
                    <svg class="w-3.5 h-3.5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-xs text-green-600 font-medium">Disponible en ligne</span>
                </div>
            </div>
        </div>

        {{-- PROGRESS BAR --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">
            <div class="flex items-center justify-between mb-3">
                @foreach([['1', 'Service'], ['2', 'Date & Heure'], ['3', 'Vos infos'], ['4', 'Confirmation']] as $i => [$num, $label])
                <div class="flex flex-col items-center gap-1 progress-step" id="progress-{{ $num }}">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold
                        {{ $num === '1' ? 'bg-[#1E3A8A] text-white' : 'bg-gray-100 text-gray-400' }}"
                        id="progress-circle-{{ $num }}">
                        {{ $num }}
                    </div>
                    <span class="text-xs text-gray-500 hidden sm:block">{{ $label }}</span>
                </div>
                @if($i < 3)
                <div class="flex-1 h-0.5 bg-gray-100 mx-2" id="progress-line-{{ $num }}"></div>
                @endif
                @endforeach
            </div>
        </div>

        {{-- ÉTAPE 1 — Choisir un service --}}
        <div class="step active fade-in" id="step-1">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-900">Choisissez un service</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Sélectionnez la prestation souhaitée</p>
                </div>
                <div class="p-4 space-y-3">
                    @forelse($services as $service)
                    <div class="service-card rounded-xl p-4" onclick="selectService({{ $service->id }}, '{{ $service->name }}', {{ $service->duration }}, {{ $service->price }})">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $service->name }}</p>
                                @if($service->description)
                                    <p class="text-gray-500 text-sm mt-0.5">{{ $service->description }}</p>
                                @endif
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="text-xs text-gray-400 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $service->duration }} min
                                    </span>
                                    @if($service->price > 0)
                                    <span class="text-xs font-semibold text-[#1E3A8A]">{{ number_format($service->price, 0, ',', ' ') }} FCFA</span>
                                    @else
                                    <span class="text-xs font-semibold text-green-600">Gratuit</span>
                                    @endif
                                </div>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex-shrink-0" id="radio-{{ $service->id }}"></div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <p class="text-gray-500">Aucun service disponible pour le moment.</p>
                    </div>
                    @endforelse
                </div>
                <div class="px-4 pb-4 flex justify-end">
                    <button onclick="goToStep(2)" id="btn-step-1" class="btn-primary" disabled>
                        Continuer →
                    </button>
                </div>
            </div>
        </div>

        {{-- ÉTAPE 2 — Choisir date et heure --}}
        <div class="step fade-in" id="step-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-900">Choisissez une date et un créneau</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Sélectionnez votre disponibilité</p>
                </div>
                <div class="p-5 space-y-5">
                    {{-- Date picker --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Date du rendez-vous</label>
                        <input type="date" id="rdv-date" class="input-field"
                            min="{{ date('Y-m-d') }}"
                            onchange="loadSlots(this.value)">
                    </div>

                    {{-- Créneaux --}}
                    <div id="slots-container" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Créneaux disponibles</label>
                        <div id="slots-grid" class="grid grid-cols-3 sm:grid-cols-4 gap-2"></div>
                    </div>

                    <div id="slots-loading" class="hidden text-center py-6">
                        <div class="w-6 h-6 border-2 border-[#1E3A8A] border-t-transparent rounded-full animate-spin mx-auto"></div>
                        <p class="text-gray-400 text-sm mt-2">Chargement des créneaux...</p>
                    </div>

                    <div id="slots-empty" class="hidden text-center py-6 bg-gray-50 rounded-xl">
                        <p class="text-gray-500 text-sm">Aucun créneau disponible pour cette date.</p>
                        <p class="text-gray-400 text-xs mt-1">Essayez une autre date.</p>
                    </div>
                </div>
                <div class="px-5 pb-5 flex justify-between">
                    <button onclick="goToStep(1)" class="text-gray-500 hover:text-gray-700 text-sm font-medium flex items-center gap-1 transition-colors">
                        ← Retour
                    </button>
                    <button onclick="goToStep(3)" id="btn-step-2" class="btn-primary" disabled>
                        Continuer →
                    </button>
                </div>
            </div>
        </div>

        {{-- ÉTAPE 3 — Infos client --}}
        <div class="step fade-in" id="step-3">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-900">Vos informations</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Pour confirmer votre réservation</p>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nom complet *</label>
                        <input type="text" id="client-name" class="input-field" placeholder="Ex: Jean Dupont" oninput="checkStep3()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Adresse email *</label>
                        <input type="email" id="client-email" class="input-field" placeholder="vous@exemple.com" oninput="checkStep3()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Téléphone <span class="text-gray-400 font-normal">(optionnel)</span></label>
                        <input type="tel" id="client-phone" class="input-field" placeholder="+229 XX XX XX XX">
                    </div>
                </div>
                <div class="px-5 pb-5 flex justify-between">
                    <button onclick="goToStep(2)" class="text-gray-500 hover:text-gray-700 text-sm font-medium flex items-center gap-1 transition-colors">
                        ← Retour
                    </button>
                    <button onclick="goToStep(4)" id="btn-step-3" class="btn-primary" disabled>
                        Continuer →
                    </button>
                </div>
            </div>
        </div>

        {{-- ÉTAPE 4 — Récapitulatif --}}
        <div class="step fade-in" id="step-4">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-900">Récapitulatif</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Vérifiez vos informations avant de confirmer</p>
                </div>
                <div class="p-5 space-y-3">
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Service</span>
                            <span class="text-sm font-semibold text-gray-900" id="recap-service">—</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Date</span>
                            <span class="text-sm font-semibold text-gray-900" id="recap-date">—</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Heure</span>
                            <span class="text-sm font-semibold text-gray-900" id="recap-time">—</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Durée</span>
                            <span class="text-sm font-semibold text-gray-900" id="recap-duration">—</span>
                        </div>
                        <div class="border-t border-blue-100 pt-3 flex justify-between items-center">
                            <span class="text-sm text-gray-500">Client</span>
                            <span class="text-sm font-semibold text-gray-900" id="recap-name">—</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Email</span>
                            <span class="text-sm font-semibold text-gray-900" id="recap-email">—</span>
                        </div>
                    </div>

                    <p class="text-xs text-gray-400 text-center">
                        Une confirmation sera envoyée à votre adresse email.
                    </p>
                </div>
                <div class="px-5 pb-5">
                    <form method="POST" action="{{ route('booking.store', $pro->id) }}" id="booking-form">
                        @csrf
                        <input type="hidden" name="service_id" id="form-service-id">
                        <input type="hidden" name="date" id="form-date">
                        <input type="hidden" name="start_time" id="form-start-time">
                        <input type="hidden" name="client_name" id="form-client-name">
                        <input type="hidden" name="client_email" id="form-client-email">
                        <input type="hidden" name="client_phone" id="form-client-phone">

                        <div class="flex justify-between items-center">
                            <button type="button" onclick="goToStep(3)" class="text-gray-500 hover:text-gray-700 text-sm font-medium flex items-center gap-1 transition-colors">
                                ← Retour
                            </button>
                            <button type="submit" class="btn-primary px-8">
                                Confirmer la réservation ✓
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    {{-- Footer --}}
    <div class="text-center pb-8 mt-4">
        <p class="text-xs text-gray-400">Propulsé par <span class="font-semibold text-[#1E3A8A]">BookEase</span></p>
    </div>

<script>
    let selectedService = null;
    let selectedSlot = null;

    function selectService(id, name, duration, price) {
        selectedService = { id, name, duration, price };

        document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));
        document.querySelectorAll('[id^="radio-"]').forEach(r => {
            r.style.background = '';
            r.style.borderColor = '#D1D5DB';
        });

        document.querySelector(`[onclick*="selectService(${id}"]`).classList.add('selected');
        const radio = document.getElementById(`radio-${id}`);
        radio.style.background = '#1E3A8A';
        radio.style.borderColor = '#1E3A8A';

        document.getElementById('btn-step-1').disabled = false;
    }

    function loadSlots(date) {
    if (!date) return;
    selectedSlot = null;
    document.getElementById('btn-step-2').disabled = true;
    document.getElementById('slots-container').classList.add('hidden');
    document.getElementById('slots-empty').classList.add('hidden');
    document.getElementById('slots-loading').classList.remove('hidden');

    fetch(`{{ route('booking.slots', $pro->id) }}?date=${date}`)
        .then(r => r.json())
        .then(slots => {
            document.getElementById('slots-loading').classList.add('hidden');
            const grid = document.getElementById('slots-grid');
            grid.innerHTML = '';

            if (slots.length === 0) {
                document.getElementById('slots-empty').classList.remove('hidden');
                return;
            }

            document.getElementById('slots-container').classList.remove('hidden');
            slots.forEach(slot => {
                const btn = document.createElement('button');
                btn.type = 'button';
                const time = slot.start_time.substring(0, 5);

                if (slot.booked) {
                    // Créneau pris
                    btn.className = 'slot-btn booked py-2.5 px-3 rounded-xl text-sm font-medium text-center relative';
                    btn.innerHTML = `${time}<span class="block text-xs text-gray-400">Pris</span>`;
                    btn.disabled = true;
                } else {
                    // Créneau disponible
                    btn.className = 'slot-btn py-2.5 px-3 rounded-xl text-sm font-medium text-center';
                    btn.innerHTML = `${time}<span class="block text-xs text-green-500">Libre</span>`;
                    btn.onclick = () => selectSlot(slot.start_time, btn);
                }
                grid.appendChild(btn);
            });
        })
        .catch(() => {
            document.getElementById('slots-loading').classList.add('hidden');
            document.getElementById('slots-empty').classList.remove('hidden');
        });
}

    function selectSlot(time, btn) {
        selectedSlot = time;
        document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        document.getElementById('btn-step-2').disabled = false;
    }

    function checkStep3() {
        const name = document.getElementById('client-name').value.trim();
        const email = document.getElementById('client-email').value.trim();
        document.getElementById('btn-step-3').disabled = !(name && email);
    }

    function goToStep(step) {
        document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
        document.getElementById(`step-${step}`).classList.add('active');

        for (let i = 1; i <= 4; i++) {
            const circle = document.getElementById(`progress-circle-${i}`);
            if (i < step) {
                circle.style.background = '#1E3A8A';
                circle.style.color = 'white';
                circle.innerHTML = '✓';
            } else if (i === step) {
                circle.style.background = '#1E3A8A';
                circle.style.color = 'white';
                circle.innerHTML = i;
            } else {
                circle.style.background = '#F3F4F6';
                circle.style.color = '#9CA3AF';
                circle.innerHTML = i;
            }
        }

        if (step === 4) fillRecap();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function fillRecap() {
        const date = document.getElementById('rdv-date').value;
        const dateFormatted = new Date(date).toLocaleDateString('fr-FR', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });

        document.getElementById('recap-service').textContent = selectedService.name;
        document.getElementById('recap-date').textContent = dateFormatted;
        document.getElementById('recap-time').textContent = selectedSlot ? selectedSlot.substring(0, 5) : '—';
        document.getElementById('recap-duration').textContent = selectedService.duration + ' min';
        document.getElementById('recap-name').textContent = document.getElementById('client-name').value;
        document.getElementById('recap-email').textContent = document.getElementById('client-email').value;

        document.getElementById('form-service-id').value = selectedService.id;
        document.getElementById('form-date').value = date;
        document.getElementById('form-start-time').value = selectedSlot;
        document.getElementById('form-client-name').value = document.getElementById('client-name').value;
        document.getElementById('form-client-email').value = document.getElementById('client-email').value;
        document.getElementById('form-client-phone').value = document.getElementById('client-phone').value;
    }
</script>

</body>
</html>