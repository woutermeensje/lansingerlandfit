<x-layouts.app>
    <x-page-hero eyebrow="Tarieven" title="Bekijk hier alle pakketten en mogelijkheden" intro="Geen inschrijfgeld en geen langlopend abonnement. Je betaalt per les of kiest voordelig voor een rittenkaart." />

    <section class="container-site py-12">
        <div class="grid gap-6 lg:grid-cols-3">
            @foreach ($prices as $plan)
                <article @class(['flex flex-col rounded-base p-8 border', 'bg-navy-700 text-white border-navy-700 lg:-translate-y-3' => $plan['highlight'] ?? false, 'bg-white border-line' => ! ($plan['highlight'] ?? false)])>
                    <h2 @class(['text-2xl', '!text-white' => $plan['highlight'] ?? false])>{{ $plan['title'] }}</h2>
                    <p class="mt-6 flex items-baseline gap-2">
                        <span class="text-5xl font-extrabold">{{ $plan['price'] }}</span>
                        <span @class(['text-sm', 'text-navy-100' => $plan['highlight'] ?? false, 'text-gray-500' => ! ($plan['highlight'] ?? false)])>{{ $plan['unit'] }}</span>
                    </p>
                    @if ($plan['extra'])
                        <p @class(['mt-2 text-sm font-semibold', 'text-mint-400' => $plan['highlight'] ?? false, 'text-mint-600' => ! ($plan['highlight'] ?? false)])>{{ $plan['extra'] }}</p>
                    @endif
                    <ul class="mt-8 flex-1 space-y-3 text-sm">
                        @foreach ($plan['features'] as $feature)
                            <li class="flex gap-3">
                                <svg class="size-5 shrink-0 text-mint-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-8 8a1 1 0 01-1.4 0l-4-4a1 1 0 111.4-1.4L8 12.58l7.3-7.3a1 1 0 011.4 0z" clip-rule="evenodd"/></svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('contact', ['interesse' => $plan['interest']]) }}" @class(['btn mt-8', 'btn-primary' => $plan['highlight'] ?? false, 'btn-navy' => ! ($plan['highlight'] ?? false)])>{{ $plan['cta'] }}</a>
                </article>
            @endforeach
        </div>

        <p class="mt-6 text-xs text-gray-500">* Alle prijzen zijn inclusief btw.</p>

        <div class="card mt-12 grid gap-8 p-8 md:grid-cols-[1fr_auto] md:items-center">
            <div>
                <h2 class="text-2xl">Overige opties: bedrijfsfitness</h2>
                <p class="mt-3 max-w-2xl text-gray-600">Bedrijfsfitness bieden we aan op basis van een offerte op maat. De prijs hangt af van het aantal deelnemers, de lesfrequentie, de locatie, de duur van de sessies, het type training en het gebruik van materialen.</p>
            </div>
            <a href="{{ route('contact', ['interesse' => 'Bedrijfsbootcamp']) }}" class="btn btn-primary">Offerte aanvragen</a>
        </div>
    </section>
</x-layouts.app>
