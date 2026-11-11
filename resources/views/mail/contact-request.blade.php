<x-mail::message>
# {{ $contact->source === 'proefles' ? 'Aanvraag gratis proefles' : 'Nieuw contactverzoek' }}

**Naam:** {{ $contact->fullName() }}<br>
**E-mail:** {{ $contact->email }}<br>
**Telefoon:** {{ $contact->phone ?: '-' }}<br>
**Interesse:** {{ $contact->interest ?: '-' }}<br>
**Via:** {{ $contact->source }}

@if ($contact->message)
**Bericht:**

{{ $contact->message }}
@endif
</x-mail::message>
