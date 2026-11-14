<x-layouts.app>
    <section>
        <div class="container-site grid items-center gap-12 py-14 lg:grid-cols-2 lg:py-20">
            <div>
                <nav class="text-sm text-gray-500" aria-label="Kruimelpad">
                    <a href="{{ route('trainingen') }}" class="hover:text-mint-600">Trainingen</a> <span aria-hidden="true">/</span> {{ $training['title'] }}
                </nav>
                <h1 class="mt-4 text-4xl sm:text-5xl">{{ $training['title'] }}</h1>
                <p class="mt-5 text-lg leading-relaxed text-gray-600">{{ $training['intro'] }}</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('proefles') }}" class="btn btn-primary">Gratis proefles</a>
                    <a href="{{ route('contact', ['interesse' => $training['interest']]) }}" class="btn btn-outline">Meer informatie</a>
                </div>
            </div>
            @if ($training['image'])
                <img src="{{ asset($training['image']) }}" alt="{{ $training['title'] }}" class="max-h-[28rem] w-full rounded-base object-cover">
            @endif
        </div>
    </section>

    <section class="container-site grid gap-12 py-14 lg:grid-cols-[2fr_1fr]">
        <div class="prose-site text-lg">
            @foreach ($training['body'] as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
        <aside class="card h-fit p-6">
            <h2 class="text-xl">Wat je kunt verwachten</h2>
            <ul class="mt-4 space-y-3 text-sm">
                @foreach ($training['benefits'] as $benefit)
                    <li class="flex gap-3">
                        <svg class="size-5 shrink-0 text-mint-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-8 8a1 1 0 01-1.4 0l-4-4a1 1 0 111.4-1.4L8 12.58l7.3-7.3a1 1 0 011.4 0z" clip-rule="evenodd"/></svg>
                        {{ $benefit }}
                    </li>
                @endforeach
            </ul>
            <a href="{{ route('tarieven') }}" class="mt-6 inline-block text-sm font-semibold text-mint-600">Bekijk de tarieven &rarr;</a>
        </aside>
    </section>

    @if ($lessons->isNotEmpty())
        <section class="bg-white py-14">
            <div class="container-site">
                <h2 class="text-3xl">Wanneer train je mee?</h2>
                <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($lessons as $lesson)
                        <div class="rounded-base bg-navy-50 p-5">
                            <p class="text-sm font-semibold text-mint-600">{{ config('site.days')[$lesson['day']] }} · {{ $lesson['from'] }} – {{ $lesson['to'] }}</p>
                            <p class="mt-1 font-semibold text-navy-700">{{ $lesson['name'] }}</p>
                            <p class="mt-1 text-sm text-gray-600">{{ $lesson['location'] }}</p>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('lesrooster') }}" class="btn btn-navy mt-8">Aanmelden via het lesrooster</a>
            </div>
        </section>
    @endif

    <section class="container-site py-14">
        <h2 class="text-3xl">Andere trainingen</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
            @foreach ($others as $otherSlug => $other)
                <x-training-card :slug="$otherSlug" :training="$other" cta="Bekijk training" />
            @endforeach
        </div>
    </section>
</x-layouts.app>
