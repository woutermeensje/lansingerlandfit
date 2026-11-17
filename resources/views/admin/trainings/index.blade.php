<x-admin.layout title="Trainingen">
    <div class="admin-page-head">
        <div>
            <h1 class="heading-1">Trainingen</h1>
            <p class="admin-muted mt-1">Elke training heeft een eigen pagina en staat in het menu, de footer en op <a href="{{ route('trainingen') }}" class="admin-link" target="_blank" rel="noopener">/trainingen</a>.</p>
        </div>
        <a href="{{ route('admin.trainings.create') }}" class="btn btn-primary">Training toevoegen</a>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th class="w-12">#</th><th>Training</th><th>Lessen</th><th class="text-right">Acties</th></tr></thead>
            <tbody>
                @forelse ($trainings as $training)
                    <tr>
                        <td class="admin-muted">{{ $training->sort_order }}</td>
                        <td>
                            <span class="admin-row__title">{{ $training->title }}</span>
                            <a href="{{ route('training', $training->slug) }}" class="admin-link block text-xs" target="_blank" rel="noopener">/{{ $training->slug }}</a>
                        </td>
                        <td>{{ $training->lessons_count ?: '–' }}</td>
                        <td>
                            <div class="admin-row__actions justify-end">
                                <a href="{{ route('admin.trainings.edit', $training) }}" class="btn btn-outline btn-sm">Bewerken</a>
                                <form method="POST" action="{{ route('admin.trainings.destroy', $training) }}" data-confirm="Training {{ $training->title }} verwijderen?{{ $training->lessons_count ? ' De '.$training->lessons_count.' '.($training->lessons_count === 1 ? 'les' : 'lessen').' van deze training verdwijnen ook uit het lesrooster.' : '' }} De pagina /{{ $training->slug }} is daarna niet meer bereikbaar.">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Verwijderen</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="admin-empty">Nog geen trainingen.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin.layout>
