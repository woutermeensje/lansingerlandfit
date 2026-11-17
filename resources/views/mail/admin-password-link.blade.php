<x-mail::message>
# {{ $invite ? 'Je bent toegevoegd als beheerder' : 'Wachtwoord opnieuw instellen' }}

Hoi {{ $name }},

@if ($invite)
Je hebt een account gekregen voor de beheeromgeving van {{ config('site.name') }}. Daar kun je het lesrooster, de trainingen en de tarieven aanpassen. Kies via de knop hieronder je wachtwoord.
@else
Je hebt gevraagd om je wachtwoord voor de beheeromgeving opnieuw in te stellen. Kies via de knop hieronder een nieuw wachtwoord.
@endif

<x-mail::button :url="$url">
{{ $invite ? 'Wachtwoord instellen' : 'Nieuw wachtwoord kiezen' }}
</x-mail::button>

Deze link werkt {{ $minutes }} minuten. Daarna vraag je via "Wachtwoord vergeten" op {{ route('admin.login') }} een nieuwe link aan.

@unless ($invite)
Heb je dit niet zelf aangevraagd? Dan hoef je niets te doen. Je wachtwoord blijft hetzelfde.
@endunless

Groet,<br>
{{ config('site.name') }}

<x-slot:subcopy>
Werkt de knop niet? Kopieer deze link in je browser: <span class="break-all">[{{ $url }}]({{ $url }})</span>
</x-slot:subcopy>
</x-mail::message>
