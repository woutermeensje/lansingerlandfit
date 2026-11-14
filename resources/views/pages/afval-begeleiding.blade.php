@php
    $benefits = [
        ['Training en voeding in één', 'Afvallen gaat het best als bewegen en eten samenkomen. Je krijgt een trainingsschema én praktische voedingsrichtlijnen die bij elkaar passen.'],
        ['Persoonlijke begeleiding', 'Geen standaard dieet, maar een aanpak die past bij jouw lichaam, agenda en smaak. We stellen bij waar nodig.'],
        ['Vaste momenten van controle', 'We meten regelmatig je voortgang: gewicht, omtrek en vooral hoe je je voelt. Zo zie je wat werkt.'],
        ['Blijvend resultaat', 'Geen crashdieet, maar gewoontes die je volhoudt. Zo blijft het gewicht er ook na de begeleiding af.'],
    ];

    $steps = [
        'Vraag een vrijblijvend kennismakingsgesprek aan.',
        'We bespreken je doel, je huidige leefstijl en wat je in het verleden al hebt geprobeerd.',
        'Je krijgt een plan op maat voor training en voeding.',
        'We trainen samen en evalueren regelmatig je voortgang.',
    ];

    $faqs = [
        ['Moet ik een streng dieet volgen?', 'Nee. We werken met haalbare aanpassingen in je eetpatroon. Je mag gewoon blijven genieten van eten.'],
        ['Hoe snel zie ik resultaat?', 'Dat verschilt per persoon. Een gezond tempo is ongeveer een halve tot een hele kilo per week. Vaak merk je al eerder dat je meer energie hebt en je kleding beter zit.'],
        ['Kan ik ook combineren met groepslessen?', 'Ja. Veel deelnemers combineren de begeleiding met Bootcamp Outdoor of Xco Walking. Dat maakt extra bewegen makkelijk en gezellig.'],
        ['Wat kost afvalbegeleiding?', 'Dat hangt af van hoe vaak we trainen en hoe intensief de begeleiding is. Vraag vrijblijvend de mogelijkheden aan, dan ontvang je een voorstel op maat.'],
    ];
@endphp

<x-layouts.app :faqs="$faqs">
    <section class="relative overflow-hidden">
        <div class="container-site grid items-center gap-12 py-14 lg:grid-cols-2 lg:py-24">
            <div>
                <p class="eyebrow">Afvalbegeleiding · Lansingerland</p>
                <h1 class="mt-4 text-4xl leading-tight sm:text-5xl lg:text-6xl">Afvallen zonder crashdieet.</h1>
                <p class="mt-6 max-w-xl text-lg leading-relaxed text-gray-600">Met persoonlijke begeleiding, training in de buitenlucht en haalbare voedingsadviezen werk je aan een gezond gewicht dat je ook vasthoudt.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#aanvragen" class="btn btn-primary">Kennismaking aanvragen</a>
                    <a href="{{ route('caloriebehoefte-calculator') }}" class="btn btn-outline">Bereken je caloriebehoefte</a>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -inset-4 rotate-3 rounded-base bg-mint-500/20" aria-hidden="true"></div>
                <img src="{{ asset('images/personal-training.png') }}" alt="Afvalbegeleiding met personal training in de buitenlucht" class="relative aspect-[4/3] w-full rounded-base object-cover">
            </div>
        </div>
    </section>

    <section class="container-site py-16">
        <p class="eyebrow">Zo pakken we het aan</p>
        <h2 class="mt-3 max-w-2xl text-3xl sm:text-4xl">Bewegen, voeding en motivatie samen</h2>
        <div class="mt-10 grid gap-5 sm:grid-cols-2">
            @foreach ($benefits as [$title, $text])
                <div class="card p-6">
                    <h3 class="text-xl">{{ $title }}</h3>
                    <p class="mt-2 leading-relaxed text-gray-600">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="container-site grid gap-12 lg:grid-cols-2">
            <div>
                <p class="eyebrow">Zo werkt het</p>
                <h2 class="mt-3 text-3xl sm:text-4xl">Van kennismaking tot resultaat</h2>
                <ol class="mt-8 space-y-5">
                    @foreach ($steps as $i => $step)
                        <li class="flex gap-4">
                            <span class="flex size-8 shrink-0 items-center justify-center rounded-full bg-mint-500 font-bold text-white">{{ $i + 1 }}</span>
                            <span class="pt-1 text-gray-700">{{ $step }}</span>
                        </li>
                    @endforeach
                </ol>
            </div>
            <div>
                <p class="eyebrow">Veelgestelde vragen</p>
                <h2 class="mt-3 text-3xl sm:text-4xl">Goed om te weten</h2>
                <div class="mt-8 space-y-3">
                    @foreach ($faqs as [$question, $answer])
                        <details class="card group p-5">
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-navy-700">
                                {{ $question }}
                                <span class="text-mint-600 transition group-open:rotate-45" aria-hidden="true">+</span>
                            </summary>
                            <p class="mt-3 leading-relaxed text-gray-600">{{ $answer }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="aanvragen" class="scroll-mt-24 py-16">
        <div class="container-site grid gap-10 lg:grid-cols-[3fr_2fr]">
            <div class="card p-6 sm:p-8">
                <h2 class="text-3xl">Vraag een kennismaking aan</h2>
                <p class="mt-3 text-gray-600">Vertel kort wat je doel is. Ik neem zo snel mogelijk contact met je op voor een vrijblijvend gesprek.</p>
                <x-contact-form class="mt-6 space-y-5" source="afval-begeleiding" interest="Afvalbegeleiding" :show-interest="false" submit="Kennismaking aanvragen" />
            </div>
            <aside class="card h-fit p-8">
                <h2 class="text-xl">Ook interessant</h2>
                <ul class="mt-4 space-y-3 text-sm">
                    <li><a href="{{ route('voedings-advies') }}" class="font-semibold text-mint-600">Voedingsadvies op maat →</a></li>
                    <li><a href="{{ route('training', 'personal-training') }}" class="font-semibold text-mint-600">Personal training →</a></li>
                    <li><a href="{{ route('caloriebehoefte-calculator') }}" class="font-semibold text-mint-600">Caloriebehoefte calculator →</a></li>
                </ul>
            </aside>
        </div>
    </section>
</x-layouts.app>
