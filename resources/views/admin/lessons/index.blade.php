<x-admin.layout title="Lesrooster">
    <div class="admin-page-head">
        <div>
            <h1 class="heading-1">Lesrooster</h1>
            <p class="admin-muted mt-1">Dit rooster staat op <a href="{{ route('lesrooster') }}" class="admin-link" target="_blank" rel="noopener">/lesrooster</a> en op de pagina's van de trainingen en locaties. Het herhaalt zich elke week.</p>
        </div>
        <a href="{{ route('admin.lessons.create') }}" class="btn btn-primary">Les toevoegen</a>
    </div>

    <div class="admin-days">
        @foreach ($days as $number => $day)
            <section class="admin-day">
                <div class="admin-day__head">
                    <h2 class="admin-day__title">{{ $day['label'] }}</h2>
                    <a href="{{ route('admin.lessons.create', ['dag' => $number]) }}" class="admin-link text-sm">+ Les op {{ strtolower($day['label']) }}</a>
                </div>
                @forelse ($day['lessons'] as $lesson)
                    <div class="admin-row">
                        <span class="admin-row__time">{{ $lesson['from'] }} – {{ $lesson['to'] }}</span>
                        <div class="admin-row__main">
                            <span class="admin-row__title">{{ $lesson['name'] }}</span>
                            <span class="admin-muted text-sm">{{ $lesson['location'] }}</span>
                        </div>
                        <div class="admin-row__actions">
                            <a href="{{ route('admin.lessons.edit', $lesson['id']) }}" class="btn btn-outline btn-sm">Bewerken</a>
                            <form method="POST" action="{{ route('admin.lessons.destroy', $lesson['id']) }}" data-confirm="Les {{ $lesson['name'] }} op {{ strtolower($day['label']) }} {{ $lesson['from'] }} verwijderen?">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Verwijderen</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="admin-day__empty">Geen lessen</p>
                @endforelse
            </section>
        @endforeach
    </div>
</x-admin.layout>
