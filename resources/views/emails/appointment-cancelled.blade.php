@component('mail::message')
# Rendez-vous annulé ❌

Bonjour **{{ $appointment->user->name }}**,

Un rendez-vous vient d'être annulé. Voici les détails :

@component('mail::panel')
**Client :** {{ $appointment->client_name }}
**Email :** {{ $appointment->client_email }}
**Service :** {{ $appointment->service->name }}
**Date :** {{ \Carbon\Carbon::parse($appointment->date)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
**Heure :** {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} — {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
@endcomponent

Ce créneau est maintenant disponible pour d'autres réservations.

@component('mail::button', ['url' => url('/dashboard'), 'color' => 'red'])
Voir mon dashboard
@endcomponent

À bientôt,
**L'équipe BookEase**
@endcomponent