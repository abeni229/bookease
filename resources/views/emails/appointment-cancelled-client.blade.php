@component('mail::message')
# Votre rendez-vous a été annulé ❌

Bonjour **{{ $appointment->client_name }}**,

Nous vous informons que votre rendez-vous a été annulé par **{{ $appointment->user->name }}**.

@component('mail::panel')
**Service :** {{ $appointment->service->name }}
**Date :** {{ \Carbon\Carbon::parse($appointment->date)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
**Heure :** {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} — {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
@endcomponent

@if($reason)
**Motif de l'annulation :** {{ $reason }}
@endif

Nous vous invitons à prendre un nouveau rendez-vous en cliquant sur le bouton ci-dessous.

@component('mail::button', ['url' => url('/reserver/' . $appointment->user_id), 'color' => 'blue'])
Prendre un nouveau rendez-vous
@endcomponent

Nous nous excusons pour la gêne occasionnée.

À bientôt,
**{{ $appointment->user->name }}** via BookEase
@endcomponent