<x-admin.layout title="Reserveringen">
    <div class="admin-page-head">
        <div>
            <h1 class="heading-1">Reserveringen</h1>
            <p class="admin-muted mt-1">Lessen die bezoekers via het <a href="{{ route('lesrooster') }}" class="admin-link" target="_blank" rel="noopener">lesrooster</a> hebben ingeboekt.</p>
        </div>
    </div>

    <nav class="admin-tabs" aria-label="Filter op periode">
        <a href="{{ route('admin.reservations.index') }}" @class(['admin-tab', 'is-active' => ! $past])>Komend <span class="admin-tab__count">{{ $counts['komend'] }}</span></a>
        <a href="{{ route('admin.reservations.index', ['periode' => 'geweest']) }}" @class(['admin-tab', 'is-active' => $past])>Geweest <span class="admin-tab__count">{{ $counts['geweest'] }}</span></a>
    </nav>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>Datum</th><th>Les</th><th>Naam</th><th>E-mail</th><th>Geboekt op</th><th class="text-right">Acties</th></tr></thead>
            <tbody>
                @forelse ($reservations as $r)
                    <tr>
                        <td class="whitespace-nowrap">{{ ucfirst($r->date->translatedFormat('D j M Y')) }}<span class="admin-muted block text-xs">{{ $r->starts_at }} – {{ $r->ends_at }}</span></td>
                        <td>{{ $r->lesson_name }}<span class="admin-muted block text-xs">{{ $r->location }}</span></td>
                        <td>{{ $r->name }}</td>
                        <td><a href="mailto:{{ $r->email }}" class="admin-link">{{ $r->email }}</a></td>
                        <td class="admin-muted whitespace-nowrap">{{ $r->created_at?->translatedFormat('j M, H:i') }}</td>
                        <td>
                            <div class="admin-row__actions justify-end">
                                <form method="POST" action="{{ route('admin.reservations.destroy', $r) }}" data-confirm="Reservering van {{ $r->name }} voor {{ $r->lesson_name }} verwijderen? {{ $r->name }} krijgt hier geen bericht over.">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Verwijderen</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="admin-empty">{{ $past ? 'Er zijn nog geen reserveringen voor lessen die al geweest zijn.' : 'Er zijn nog geen reserveringen voor de komende lessen.' }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <x-admin.pager :items="$reservations" />
</x-admin.layout>
