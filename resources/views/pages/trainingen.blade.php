<x-layouts.app>
    <x-page-hero eyebrow="Trainingen" title="Onze trainingen, lesrooster en locaties." intro="We trainen buiten in Pijnacker, Berkel en Rodenrijs, Bergschenhoek, Bleiswijk en Nootdorp. Kies de training die bij jou past." />

    <section class="container-site py-12">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($trainings as $slug => $training)
                <x-training-card :slug="$slug" :training="$training" cta="Bekijk training" />
            @endforeach
        </div>
    </section>

    <section id="weekrooster" class="bg-white py-16">
        <div class="container-site">
            <p class="eyebrow">Rooster</p>
            <h2 class="mt-3 text-3xl sm:text-4xl">Ons weekrooster</h2>
            <div class="mt-8">
                <x-schedule :days="$days" />
            </div>
        </div>
    </section>

    <section class="container-site py-16">
        <p class="eyebrow">Locaties</p>
        <h2 class="mt-3 text-3xl sm:text-4xl">Hier trainen we</h2>
        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($locations as $slug => $location)
                <a href="{{ route('locatie', $slug) }}" class="card group overflow-hidden">
                    <div class="aspect-[4/3] overflow-hidden bg-mint-100">
                        <img src="{{ asset($location['image']) }}" alt="Trainingslocatie {{ $location['title'] }}" loading="lazy" class="size-full object-cover transition duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg">{{ $location['title'] }}</h3>
                        <span class="mt-2 inline-block text-sm font-semibold text-mint-600">Bekijk locatie &rarr;</span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
</x-layouts.app>
