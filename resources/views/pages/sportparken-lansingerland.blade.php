<x-layouts.app>
    <x-page-hero eyebrow="Buiten sporten" title="Sportparken en buitensportplekken in Lansingerland" intro="Lansingerland heeft prachtige groene plekken om te sporten. Hier vind je de locaties waar wij trainen, en een paar favoriete plekken om zelf aan de slag te gaan." />

    <section class="container-site py-12">
        <div class="grid gap-6 md:grid-cols-2">
            @foreach ($parks as $park)
                <article class="card overflow-hidden">
                    <img src="{{ asset($park['image']) }}" alt="{{ $park['title'] }} in {{ $park['place'] }}" class="aspect-[16/9] w-full object-cover" loading="lazy">
                    <div class="p-6">
                        <p class="eyebrow">{{ $park['place'] }}</p>
                        <h2 class="mt-2 text-2xl">{{ $park['title'] }}</h2>
                        <p class="mt-3 leading-relaxed text-gray-600">{{ $park['text'] }}</p>
                        <ul class="mt-4 flex flex-wrap gap-2">
                            @foreach ($park['activities'] as $activity)
                                <li class="rounded-full bg-mint-100 px-3 py-1 text-xs font-semibold text-mint-600">{{ $activity }}</li>
                            @endforeach
                        </ul>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="bg-white py-14">
        <div class="container-site grid gap-12 lg:grid-cols-2">
            <div class="prose-site">
                <h2>Waarom buiten sporten?</h2>
                <p>Trainen in de buitenlucht is goed voor lichaam én hoofd. Je krijgt daglicht en frisse lucht, de ondergrond wisselt en je oefeningen zijn nooit precies hetzelfde. Bovendien voelt een training in het groen al snel minder als moeten en meer als ontspanning.</p>
                <p>Bij LansingerlandFit trainen we het hele jaar door buiten, in kleine groepen en op ieder niveau. Je hoeft geen lid te worden van een sportschool: we nemen alle materialen mee.</p>
            </div>
            <div>
                <h2 class="text-2xl">Trainen per woonplaats</h2>
                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    @foreach (config('site.locations') as $slug => $location)
                        <a href="{{ route('locatie', $slug) }}" class="rounded-base bg-navy-50 p-5 font-semibold text-navy-700 hover:bg-mint-100">
                            Buiten sporten in {{ $location['title'] }} →
                        </a>
                    @endforeach
                </div>
                <a href="{{ route('lesrooster') }}" class="btn btn-navy mt-8">Bekijk het lesrooster</a>
            </div>
        </div>
    </section>
</x-layouts.app>
