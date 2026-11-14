<x-layouts.app>
    <section>
        <div class="container-site grid items-center gap-12 py-14 lg:grid-cols-2 lg:py-20">
            <div>
                <p class="eyebrow">Locatie</p>
                <h1 class="mt-3 text-4xl sm:text-5xl">Buiten sporten in {{ $location['title'] }}</h1>
                <p class="mt-5 text-lg leading-relaxed text-gray-600">{{ $location['intro'] }}</p>
                <a href="{{ route('proefles') }}" class="btn btn-primary mt-8">Gratis proefles</a>
            </div>
            <img src="{{ asset($location['image']) }}" alt="Trainingslocatie {{ $location['title'] }}" class="aspect-[4/3] w-full rounded-base object-cover">
        </div>
    </section>

    <section class="container-site py-14">
        <h2 class="text-3xl">Lessen in {{ $location['title'] }}</h2>
        @if ($lessons->isEmpty())
            <p class="mt-4 max-w-2xl text-gray-600">Op dit moment staan hier geen vaste groepslessen op het rooster. Personal training en bedrijfsbootcamps zijn wel mogelijk in {{ $location['title'] }}. <a href="{{ route('contact') }}" class="font-semibold text-mint-600 underline underline-offset-4">Neem contact op</a> voor de mogelijkheden.</p>
        @else
            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($lessons as $lesson)
                    <a href="{{ route('training', $lesson['training']) }}" class="rounded-base bg-white p-5 border border-line hover:border-mint-500">
                        <p class="text-sm font-semibold text-mint-600">{{ config('site.days')[$lesson['day']] }} · {{ $lesson['from'] }} – {{ $lesson['to'] }}</p>
                        <p class="mt-1 font-semibold text-navy-700">{{ $lesson['name'] }}</p>
                        <p class="mt-1 text-sm text-gray-600">{{ $lesson['location'] }}</p>
                    </a>
                @endforeach
            </div>
            <a href="{{ route('lesrooster') }}" class="btn btn-navy mt-8">Naar het lesrooster</a>
        @endif
    </section>
</x-layouts.app>
