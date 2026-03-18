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
        .btn-primary {
            background: #1E3A8A; color: white;
            padding: 10px 20px; border-radius: 10px;
            font-size: 14px; font-weight: 600;
            border: none; cursor: pointer; transition: all 0.2s;
        }
        .btn-primary:hover { background: #1D4ED8; transform: translateY(-1px); }
        .modal { display: none; position: fixed; inset: 0; z-index: 50; }
        .modal.open { display: flex; }
        .service-card { transition: all 0.2s; }
        .service-card:hover { box-shadow: 0 4px 20px rgba(30,58,138,0.1); }
    </style>
</head>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Mes services</h2>
                <p class="text-sm text-gray-500 mt-0.5">Gérez les prestations proposées à vos clients</p>
            </div>
            <button onclick="openModal('modal-create')"
                class="btn-primary flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouveau service
            </button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Alerts --}}
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            {{-- Empty state --}}
            @if($services->isEmpty())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
                <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-[#1E3A8A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <p class="font-semibold text-gray-900 mb-1">Aucun service créé</p>
                <p class="text-gray-400 text-sm mb-6">Créez vos premiers services pour commencer à recevoir des réservations</p>
                <button onclick="openModal('modal-create')" class="btn-primary">
                    Créer mon premier service
                </button>
            </div>

            @else

            {{-- Stats rapides --}}
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ $services->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Total services</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $services->where('is_active', true)->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Actifs</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-bold text-gray-400">{{ $services->where('is_active', false)->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Inactifs</p>
                </div>
            </div>

            {{-- Liste des services --}}
            <div class="space-y-3">
                @foreach($services as $service)
                <div class="service-card bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-[#1E3A8A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $service->name }}</p>
                            @if($service->description)
                                <p class="text-gray-400 text-sm mt-0.5">{{ $service->description }}</p>
                            @endif
                            <div class="flex items-center gap-3 mt-1.5">
                                <span class="text-xs text-gray-400 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $service->duration }} min
                                </span>
                                <span class="text-xs font-semibold {{ $service->price > 0 ? 'text-[#1E3A8A]' : 'text-green-600' }}">
                                    {{ $service->price > 0 ? number_format($service->price, 0, ',', ' ').' FCFA' : 'Gratuit' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 flex-shrink-0">
                        {{-- Toggle actif/inactif --}}
                        <form method="POST" action="{{ route('services.toggle', $service) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="text-xs px-3 py-1.5 rounded-lg font-medium transition-all
                                {{ $service->is_active
                                    ? 'bg-green-50 text-green-600 hover:bg-green-100 border border-green-200'
                                    : 'bg-gray-50 text-gray-400 hover:bg-gray-100 border border-gray-200' }}">
                                {{ $service->is_active ? 'Actif' : 'Inactif' }}
                            </button>
                        </form>

                        {{-- Modifier --}}
                        <button onclick="openEdit(
                            {{ $service->id }},
                            '{{ addslashes($service->name) }}',
                            '{{ addslashes($service->description ?? '') }}',
                            {{ $service->duration }},
                            {{ $service->price }}
                        )" class="p-2 text-gray-400 hover:text-[#1E3A8A] hover:bg-blue-50 rounded-lg transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>

                        {{-- Supprimer --}}
                        <form method="POST" action="{{ route('services.destroy', $service) }}"
                            onsubmit="return confirm('Supprimer ce service ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- MODAL CRÉER --}}
    <div class="modal" id="modal-create">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('modal-create')"></div>
        <div class="relative m-auto bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-gray-900 text-lg">Nouveau service</h3>
                <button onclick="closeModal('modal-create')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('services.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nom du service *</label>
                    <input type="text" name="name" class="input-field" placeholder="Ex: Coupe homme" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                    <textarea name="description" class="input-field" rows="2" placeholder="Description courte..."></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Durée (min) *</label>
                        <input type="number" name="duration" class="input-field" placeholder="30" min="5" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Prix (FCFA) *</label>
                        <input type="number" name="price" class="input-field" placeholder="0" min="0" required>
                    </div>
                </div>
                <button type="submit" class="btn-primary w-full mt-2">Créer le service</button>
            </form>
        </div>
    </div>

    {{-- MODAL MODIFIER --}}
    <div class="modal" id="modal-edit">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('modal-edit')"></div>
        <div class="relative m-auto bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-gray-900 text-lg">Modifier le service</h3>
                <button onclick="closeModal('modal-edit')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form method="POST" id="edit-form" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nom du service *</label>
                    <input type="text" name="name" id="edit-name" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                    <textarea name="description" id="edit-description" class="input-field" rows="2"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Durée (min) *</label>
                        <input type="number" name="duration" id="edit-duration" class="input-field" min="5" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Prix (FCFA) *</label>
                        <input type="number" name="price" id="edit-price" class="input-field" min="0" required>
                    </div>
                </div>
                <button type="submit" class="btn-primary w-full mt-2">Enregistrer les modifications</button>
            </form>
        </div>
    </div>

<script>
    function openModal(id) { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }

    function openEdit(id, name, description, duration, price) {
        document.getElementById('edit-form').action = `/services/${id}`;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-description').value = description;
        document.getElementById('edit-duration').value = duration;
        document.getElementById('edit-price').value = price;
        openModal('modal-edit');
    }
</script>

</x-app-layout>