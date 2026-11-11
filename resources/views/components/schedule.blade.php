@props(['days'])

@php
    $trainer = config('site.trainer');
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
@endphp

<div data-schedule>
    <div class="inline-flex rounded-full bg-white p-1 ring-1 ring-navy-100" role="tablist">
        <button type="button" role="tab" data-schedule-tab="week" aria-selected="true" class="rounded-full px-5 py-2 text-sm font-semibold text-navy-700 aria-selected:bg-navy-700 aria-selected:text-white">Doordeweeks</button>
        <button type="button" role="tab" data-schedule-tab="weekend" aria-selected="false" class="rounded-full px-5 py-2 text-sm font-semibold text-navy-700 aria-selected:bg-navy-700 aria-selected:text-white">Weekend</button>
    </div>

    <div class="mt-8 grid items-start gap-5 md:grid-cols-2 xl:grid-cols-5">
        @foreach ($days as $number => $day)
            <section data-schedule-group="{{ $number >= 6 ? 'weekend' : 'week' }}" @class(['card p-5', 'hidden' => $number >= 6])>
                <div class="flex items-baseline justify-between">
                    <h3 class="text-lg">{{ $day['label'] }}</h3>
                    <span class="text-xs text-gray-500">{{ $day['lessons']->count() }} {{ $day['lessons']->count() === 1 ? 'les' : 'lessen' }}</span>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse ($day['lessons'] as $lesson)
                        <div class="rounded-2xl bg-navy-50 p-4">
                            <p class="text-xs font-semibold text-mint-600">{{ $lesson['from'] }} – {{ $lesson['to'] }}</p>
                            <p class="mt-1 font-semibold text-navy-700">
                                <a href="{{ route('training', $lesson['training']) }}" class="hover:underline">{{ $lesson['name'] }}</a>
                            </p>
                            <p class="mt-1 text-xs text-gray-600">{{ $lesson['location'] }}</p>
                            <p class="text-xs text-gray-500">{{ $trainer }}</p>
                            <button type="button" class="btn btn-primary mt-3 w-full !py-2 !text-xs" data-reserve='@json($payload($lesson))'>Aanmelden</button>
                        </div>
                    @empty
                        <p class="rounded-2xl border border-dashed border-navy-100 p-4 text-sm text-gray-500">Geen lessen</p>
                    @endforelse
                </div>
            </section>
        @endforeach
    </div>
</div>

@once
    <dialog id="reservation-dialog" class="m-auto w-[calc(100%-2rem)] max-w-md rounded-3xl p-0 shadow-2xl backdrop:bg-navy-900/60" @if ($reopen) data-reopen='@json($reopen)' @endif>
        <form method="POST" action="{{ route('reservations.store') }}" class="p-6 sm:p-8">
            @csrf
            <input type="hidden" name="lesson_id" value="{{ old('lesson_id') }}">

            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="eyebrow">Reserveer jouw training</p>
                    <h2 class="mt-2 text-2xl" data-lesson-name></h2>
                    <p class="mt-1 text-sm text-gray-600" data-lesson-meta></p>
                </div>
                <button type="button" data-dialog-close class="-mr-2 -mt-2 rounded-full p-2 text-2xl leading-none text-gray-400 hover:text-navy-700" aria-label="Sluiten">&times;</button>
            </div>

            @if ($errors->hasAny(['lesson_id', 'date', 'name', 'email']) && old('lesson_id'))
                <div class="mt-4 rounded-xl bg-red-50 p-3 text-sm text-red-700">
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
