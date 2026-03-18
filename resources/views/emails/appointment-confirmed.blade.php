@component('mail::message')
# Votre rendez-vous est confirmé ! ✅

Bonjour **{{ $appointment->client_name }}**,

Votre rendez-vous a bien été enregistré. Voici le récapitulatif :

@component('mail::panel')
**Service :** {{ $appointment->service->name }}
**Date :** {{ \Carbon\Carbon::parse($appointment->date)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
**Heure :** {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} — {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
**Durée :** {{ $appointment->service->duration }} min
**Professionnel :** {{ $appointment->user->name }}
@endcomponent

@if($appointment->service->price > 0)
**Montant à régler :** {{ number_format($appointment->service->price, 0, ',', ' ') }} FCFA
@endif

Merci de votre confiance. En cas de besoin, contactez directement votre professionnel.

@component('mail::button', ['url' => url('/'), 'color' => 'blue'])
Voir BookEase
@endcomponent

À bientôt,
**L'équipe BookEase**
@endcomponent