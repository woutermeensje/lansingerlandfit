<x-admin.layout title="Dashboard">
    <div class="admin-page-head">
        <div>
            <h1 class="heading-1">Dashboard</h1>
            <p class="admin-muted mt-1">Hoi {{ auth()->user()->name }}. Wat wil je aanpassen?</p>
        </div>
    </div>

    <div class="admin-tiles">
        <a href="{{ route('admin.lessons.index') }}" class="admin-tile">
            <span class="admin-tile__title">Lesrooster</span>
            <span class="admin-muted">{{ $counts['lessons'] }} {{ $counts['lessons'] === 1 ? 'les' : 'lessen' }} per week</span>
        </a>
        <a href="{{ route('admin.trainings.index') }}" class="admin-tile">
            <span class="admin-tile__title">Trainingen</span>
            <span class="admin-muted">{{ $counts['trainings'] }} {{ $counts['trainings'] === 1 ? 'training' : 'trainingen' }}</span>
        </a>
        <a href="{{ route('admin.prices.index') }}" class="admin-tile">
            <span class="admin-tile__title">Tarieven</span>
            <span class="admin-muted">{{ $counts['prices'] }} {{ $counts['prices'] === 1 ? 'pakket' : 'pakketten' }}</span>
        </a>
    </div>

    <section class="admin-section">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <h2 class="heading-2">Komende reserveringen</h2>
            <a href="{{ route('admin.reservations.index') }}" class="admin-link text-sm">Alle reserveringen &rarr;</a>
        </div>
        @if ($reservations->isEmpty())
            <p class="admin-empty">Er zijn nog geen reserveringen voor de komende lessen.</p>
        @else
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead><tr><th>Datum</th><th>Les</th><th>Naam</th><th>E-mail</th></tr></thead>
                    <tbody>
                        @foreach ($reservations as $r)
                            <tr>
                                <td class="whitespace-nowrap">{{ ucfirst($r->date->translatedFormat('D j M')) }}, {{ $r->starts_at }}</td>
                                <td>{{ $r->lesson_name }}<span class="admin-muted block text-xs">{{ $r->location }}</span></td>
                                <td>{{ $r->name }}</td>
                                <td><a href="mailto:{{ $r->email }}" class="admin-link">{{ $r->email }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>

    <section class="admin-section">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <h2 class="heading-2">Laatste aanvragen</h2>
            <a href="{{ route('admin.contact-requests.index') }}" class="admin-link text-sm">Alle aanvragen &rarr;</a>
        </div>
        @if ($contacts->isEmpty())
            <p class="admin-empty">Er zijn nog geen aanvragen via het contactformulier.</p>
        @else
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead><tr><th>Ontvangen</th><th>Naam</th><th>Formulier</th><th>Contact</th></tr></thead>
                    <tbody>
                        @foreach ($contacts as $c)
                            <tr>
                                <td class="whitespace-nowrap">{{ $c->created_at->translatedFormat('j M, H:i') }}</td>
                                <td>{{ $c->first_name }} {{ $c->last_name }}@if ($c->message)<span class="admin-muted block text-xs">{{ \Illuminate\Support\Str::limit($c->message, 90) }}</span>@endif</td>
                                <td>{{ $c->sourceLabel() }}</td>
                                <td><a href="mailto:{{ $c->email }}" class="admin-link">{{ $c->email }}</a>@if ($c->phone)<span class="admin-muted block text-xs">{{ $c->phone }}</span>@endif</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</x-admin.layout>
