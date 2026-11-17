<x-admin.layout title="Tarieven">
    <div class="admin-page-head">
        <div>
            <h1 class="heading-1">Tarieven</h1>
            <p class="admin-muted mt-1">De pakketten op <a href="{{ route('tarieven') }}" class="admin-link" target="_blank" rel="noopener">/tarieven</a>, in deze volgorde.</p>
        </div>
        <a href="{{ route('admin.prices.create') }}" class="btn btn-primary">Tarief toevoegen</a>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th class="w-12">#</th><th>Pakket</th><th>Prijs</th><th class="text-right">Acties</th></tr></thead>
            <tbody>
                @forelse ($prices as $price)
                    <tr>
                        <td class="admin-muted">{{ $price->sort_order }}</td>
                        <td>
                            <span class="admin-row__title">{{ $price->title }}</span>
                            @if ($price->highlight)<span class="admin-badge">Uitgelicht</span>@endif
                        </td>
                        <td class="whitespace-nowrap">{{ $price->price }} <span class="admin-muted">{{ $price->unit }}</span>@if ($price->extra)<span class="admin-muted block text-xs">{{ $price->extra }}</span>@endif</td>
                        <td>
                            <div class="admin-row__actions justify-end">
                                <a href="{{ route('admin.prices.edit', $price) }}" class="btn btn-outline btn-sm">Bewerken</a>
                                <form method="POST" action="{{ route('admin.prices.destroy', $price) }}" data-confirm="Tarief {{ $price->title }} verwijderen?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Verwijderen</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="admin-empty">Nog geen tarieven.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin.layout>
