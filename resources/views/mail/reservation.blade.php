<x-mail::message>
# Je reservering is bevestigd

Hoi {{ $reservation->name }},

Leuk dat je komt trainen! Hieronder vind je de gegevens van je les.

<x-mail::panel>
**{{ $reservation->lesson_name }}**<br>
{{ ucfirst($reservation->date->translatedFormat('l j F Y')) }}, {{ $reservation->starts_at }} – {{ $reservation->ends_at }}<br>
{{ $reservation->location }}
</x-mail::panel>

Kun je toch niet? Laat het even weten via {{ config('site.contact.phone') }} of {{ config('site.contact.email') }}.

Sportieve groet,<br>
{{ config('site.contact.person') }}<br>
{{ config('site.name') }}
</x-mail::message>
