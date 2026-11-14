@props(['days'])

@php
    $trainer = config('site.trainer');
    $trainings = config('site.trainings');
    $payload = function (array $lesson) {
        return [
            'id' => $lesson['id'],
            'name' => $lesson['name'],
            'day' => config('site.days')[$lesson['day']],
            'from' => $lesson['from'],
            'to' => $lesson['to'],
            'location' => $lesson['location'],
            'dates' => \App\Support\Schedule::upcomingDates($lesson)->map(fn ($d) => [
                'value' => $d->toDateString(),
                'label' => ucfirst($d->translatedFormat('l j F')),
            ])->all(),
        ];
    };
    $reopen = old('lesson_id') && ($l = \App\Support\Schedule::find(old('lesson_id'))) ? $payload($l) : null;

    $minutes = fn (string $time) => (int) substr($time, 0, 2) * 60 + (int) substr($time, 3, 2);

    // Vaste kleur per training, in volgorde van voorkomen in het rooster.
    $tones = ['mint', 'navy', 'sand'];
    $legend = $days->pluck('lessons')->flatten(1)->unique('training')->values()
        ->mapWithKeys(fn ($lesson, $i) => [$lesson['training'] => [
            'tone' => $tones[$i % count($tones)],
            'name' => $trainings[$lesson['training']]['title'] ?? $lesson['name'],
        ]]);

    $now = now();
    $today = $now->dayOfWeekIso;
    $nowMinutes = $now->hour * 60 + $now->minute;

    // Per tabblad: de dagen en het tijdvenster (hele uren) van de kalender.
    $groups = collect(['week' => [1, 2, 3, 4, 5], 'weekend' => [6, 7]])->map(function ($numbers) use ($days, $minutes) {
        $groupDays = $days->only($numbers);
        $lessons = $groupDays->pluck('lessons')->flatten(1);
        $start = $lessons->isEmpty() ? 8 : intdiv($lessons->min(fn ($l) => $minutes($l['from'])), 60);
        $end = $lessons->isEmpty() ? 12 : (int) ceil($lessons->max(fn ($l) => $minutes($l['to'])) / 60);

        return ['days' => $groupDays, 'start' => $start, 'end' => max($end, $start + 1)];
    });
    $activeGroup = $today >= 6 ? 'weekend' : 'week';
@endphp

<div data-schedule class="schedule">
    <div class="schedule__toolbar">
        <div class="btn-toggle" role="tablist" aria-label="Kies dagen">
            @foreach (['week' => 'Doordeweeks', 'weekend' => 'Weekend'] as $key => $label)
                <button type="button" role="tab" data-schedule-tab="{{ $key }}" aria-selected="{{ $key === $activeGroup ? 'true' : 'false' }}" class="btn-toggle__option">{{ $label }}</button>
            @endforeach
        </div>

        <ul class="schedule__legend" aria-label="Legenda">
            @foreach ($legend as $slug => $item)
                <li>
                    <a href="{{ route('training', $slug) }}" class="schedule__legend-item">
                        <span class="schedule__swatch schedule__swatch--{{ $item['tone'] }}" aria-hidden="true"></span>{{ $item['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    @foreach ($groups as $key => $group)
        @php $hours = $group["end"] - $group["start"]; @endphp
        <div data-schedule-group="{{ $key }}" @class(['hidden' => $key !== $activeGroup])>

            {{-- Desktop: weekkalender met tijdas --}}
            <div class="schedule__calendar" style="--days: {{ $group['days']->count() }}; --hours: {{ $hours }}">
                <div class="schedule__corner" aria-hidden="true"></div>
                @foreach ($group['days'] as $number => $day)
                    <div @class(['schedule__day-head', 'is-today' => $number === $today])>
                        <span class="schedule__day-name">{{ $day['label'] }}</span>
                        @if ($number === $today)
                            <span class="schedule__today">Vandaag</span>
                        @else
                            <span class="schedule__day-count">{{ $day['lessons']->count() ?: 'Geen' }} {{ $day['lessons']->count() === 1 ? 'les' : 'lessen' }}</span>
                        @endif
                    </div>
                @endforeach

                <div class="schedule__times" aria-hidden="true">
                    @for ($h = $group['start']; $h < $group['end']; $h++)
                        <span class="schedule__time">{{ sprintf('%02d:00', $h) }}</span>
                    @endfor
                </div>

                @foreach ($group['days'] as $number => $day)
                    <div @class(['schedule__column', 'is-today' => $number === $today])>
                        @foreach ($day['lessons'] as $lesson)
                            @php
                                $offset = $minutes($lesson['from']) - $group['start'] * 60;
                                $length = $minutes($lesson['to']) - $minutes($lesson['from']);
                            @endphp
                            <button type="button"
                                class="schedule__event schedule__event--{{ $legend[$lesson['training']]['tone'] }}"
                                style="top: {{ $offset / ($hours * 60) * 100 }}%; height: {{ $length / ($hours * 60) * 100 }}%"
                                data-reserve='@json($payload($lesson))'
                                aria-label="Aanmelden voor {{ $lesson['name'] }}, {{ $day['label'] }} {{ $lesson['from'] }} tot {{ $lesson['to'] }}, {{ $lesson['location'] }}">
                                <span class="schedule__event-time">{{ $lesson['from'] }} – {{ $lesson['to'] }}</span>
                                <span class="schedule__event-name">{{ $lesson['name'] }}</span>
                                <span class="schedule__event-location">{{ $lesson['location'] }}</span>
                            </button>
                        @endforeach

                        @if ($number === $today && $nowMinutes >= $group['start'] * 60 && $nowMinutes < $group['end'] * 60)
                            <span class="schedule__now" style="top: {{ ($nowMinutes - $group['start'] * 60) / ($hours * 60) * 100 }}%" aria-hidden="true"></span>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Mobiel: agenda per dag --}}
            <div class="schedule__agenda">
                @foreach ($group['days'] as $number => $day)
                    <section class="schedule__agenda-day">
                        <h3 class="schedule__agenda-head">
                            {{ $day['label'] }}
                            @if ($number === $today)<span class="schedule__today">Vandaag</span>@endif
                        </h3>
                        @forelse ($day['lessons'] as $lesson)
                            <div class="schedule__agenda-item">
                                <span class="schedule__swatch schedule__swatch--{{ $legend[$lesson['training']]['tone'] }} schedule__swatch--bar" aria-hidden="true"></span>
                                <div class="schedule__agenda-time">
                                    <span>{{ $lesson['from'] }}</span>
                                    <span class="schedule__agenda-until">{{ $lesson['to'] }}</span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="schedule__agenda-name">
                                        <a href="{{ route('training', $lesson['training']) }}">{{ $lesson['name'] }}</a>
                                    </p>
                                    <p class="schedule__agenda-meta">{{ $lesson['location'] }}</p>
                                    <p class="schedule__agenda-meta">{{ $trainer }}</p>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm" data-reserve='@json($payload($lesson))'>Aanmelden</button>
                            </div>
                        @empty
                            <p class="schedule__agenda-empty">Geen lessen</p>
                        @endforelse
                    </section>
                @endforeach
            </div>
        </div>
    @endforeach

    <p class="schedule__hint">Alle lessen worden gegeven door {{ $trainer }}. Klik op een les om je aan te melden.</p>
</div>

@once
    <dialog id="reservation-dialog" class="m-auto w-[calc(100%-2rem)] max-w-md rounded-base p-0 backdrop:bg-navy-900/60" @if ($reopen) data-reopen='@json($reopen)' @endif>
        <form method="POST" action="{{ route('reservations.store') }}" class="p-6 sm:p-8">
            @csrf
            <input type="hidden" name="lesson_id" value="{{ old('lesson_id') }}">

            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="eyebrow">Reserveer jouw training</p>
                    <h2 class="mt-2 text-2xl" data-lesson-name></h2>
                    <p class="mt-1 text-sm text-gray-600" data-lesson-meta></p>
                </div>
                <button type="button" data-dialog-close class="-mr-2 -mt-2 p-2 text-2xl leading-none text-gray-400 hover:text-navy-700" aria-label="Sluiten">&times;</button>
            </div>

            @if ($errors->hasAny(['lesson_id', 'date', 'name', 'email']) && old('lesson_id'))
                <div class="mt-4 rounded-base bg-red-50 p-3 text-sm text-red-700">
                    @foreach ($errors->only(['lesson_id', 'date', 'name', 'email']) as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                </div>
            @endif

            <div class="mt-6 space-y-4">
                <div>
                    <label for="reservation-date" class="form-label">Datum</label>
                    <select id="reservation-date" name="date" class="form-input" required></select>
                </div>
                <div>
                    <label for="reservation-name" class="form-label">Naam</label>
                    <input id="reservation-name" name="name" value="{{ old('name') }}" class="form-input" required autocomplete="name">
                </div>
                <div>
                    <label for="reservation-email" class="form-label">E-mailadres</label>
                    <input id="reservation-email" type="email" name="email" value="{{ old('email') }}" class="form-input" required autocomplete="email">
                </div>
            </div>

            <p class="mt-4 text-xs leading-relaxed text-gray-500">Je reservering wordt opgeslagen en je ontvangt een bevestiging op dit e-mailadres.</p>

            <button type="submit" class="btn btn-primary mt-6 w-full">Bevestig reservering</button>
        </form>
    </dialog>
@endonce
