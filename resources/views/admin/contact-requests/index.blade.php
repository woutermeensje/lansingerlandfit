<x-admin.layout title="Aanvragen">
    <div class="admin-page-head">
        <div>
            <h1 class="heading-1">Aanvragen</h1>
            <p class="admin-muted mt-1">Alles wat via de formulieren op de site binnenkomt: contact, gratis proefles en de landingspagina's. Nieuwste bovenaan.</p>
        </div>
    </div>

    <nav class="admin-tabs" aria-label="Filter op formulier">
        <a href="{{ route('admin.contact-requests.index') }}" @class(['admin-tab', 'is-active' => ! $source])>Alles <span class="admin-tab__count">{{ $counts->sum() }}</span></a>
        @foreach (\App\Models\ContactRequest::SOURCES as $key => $label)
            <a href="{{ route('admin.contact-requests.index', ['bron' => $key]) }}" @class(['admin-tab', 'is-active' => $source === $key])>{{ $label }} <span class="admin-tab__count">{{ $counts[$key] ?? 0 }}</span></a>
        @endforeach
    </nav>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>Ontvangen</th><th>Naam en bericht</th><th>Formulier</th><th>Contact</th><th class="text-right">Acties</th></tr></thead>
            <tbody>
                @forelse ($requests as $c)
                    <tr>
                        <td class="whitespace-nowrap align-top">{{ $c->created_at->translatedFormat('j M Y') }}<span class="admin-muted block text-xs">{{ $c->created_at->format('H:i') }}</span></td>
                        <td class="align-top">
                            <span class="admin-row__title">{{ $c->fullName() }}</span>
                            @if ($c->message)
                                <p class="admin-message">{{ $c->message }}</p>
                            @endif
                        </td>
                        <td class="align-top">{{ $c->sourceLabel() }}@if ($c->interest && $c->interest !== $c->sourceLabel())<span class="admin-muted block text-xs">Interesse: {{ $c->interest }}</span>@endif</td>
                        <td class="align-top"><a href="mailto:{{ $c->email }}" class="admin-link">{{ $c->email }}</a>@if ($c->phone)<a href="tel:{{ preg_replace('/[^\d+]/', '', $c->phone) }}" class="admin-muted block text-xs">{{ $c->phone }}</a>@endif</td>
                        <td class="align-top">
                            <div class="admin-row__actions justify-end">
                                <form method="POST" action="{{ route('admin.contact-requests.destroy', $c) }}" data-confirm="Aanvraag van {{ $c->fullName() }} verwijderen? Dit kan niet ongedaan worden gemaakt.">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Verwijderen</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="admin-empty">Er zijn nog geen aanvragen{{ $source ? ' via dit formulier' : '' }}.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <x-admin.pager :items="$requests" />
</x-admin.layout>
