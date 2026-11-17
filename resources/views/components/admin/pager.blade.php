@props(['items'])

@if ($items->hasPages())
    <nav class="admin-pager" aria-label="Pagina's">
        <span class="admin-muted text-sm">{{ $items->firstItem() }}–{{ $items->lastItem() }} van {{ $items->total() }}</span>
        <div class="admin-row__actions">
            @if ($items->onFirstPage())
                <span class="btn btn-outline btn-sm opacity-40" aria-disabled="true">Vorige</span>
            @else
                <a href="{{ $items->previousPageUrl() }}" class="btn btn-outline btn-sm" rel="prev">Vorige</a>
            @endif
            @if ($items->hasMorePages())
                <a href="{{ $items->nextPageUrl() }}" class="btn btn-outline btn-sm" rel="next">Volgende</a>
            @else
                <span class="btn btn-outline btn-sm opacity-40" aria-disabled="true">Volgende</span>
            @endif
        </div>
    </nav>
@endif
