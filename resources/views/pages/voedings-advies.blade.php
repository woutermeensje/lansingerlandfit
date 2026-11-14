@php
    $topics = [
        ['Gezond afvallen', 'Een eetpatroon met een klein energietekort, zonder honger of strenge regels.'],
        ['Meer energie', 'Voeding die je de hele dag scherp en fit houdt, zonder dip na de lunch.'],
        ['Sporten en herstel', 'Wat eet je voor en na een training om sterker te worden en goed te herstellen?'],
        ['Drukke agenda', 'Snelle, gezonde maaltijden en slimme boodschappen voor als het tijd kost om te koken.'],
    ];

    $includes = [
        'Intakegesprek over je eetpatroon, doelen en leefstijl',
        'Inzicht in je caloriebehoefte en de verdeling van eiwitten, koolhydraten en vetten',
        'Praktische voedingsrichtlijnen en voorbeeldmaaltijden',
        'Tips voor boodschappen, uit eten en verjaardagen',
        'Tussentijdse evaluatie en bijsturing',
    ];

    $faqs = [
        ['Krijg ik een vast weekmenu?', 'Je krijgt richtlijnen en voorbeelden waarmee je zelf aan de slag kunt. Zo leer je keuzes maken die passen bij jouw dag, in plaats van een lijstje af te werken.'],
        ['Moet ik alles bijhouden in een app?', 'Dat hoeft niet. Voor sommige mensen werkt het om een tijdje bij te houden wat ze eten, voor anderen niet. We kiezen samen wat bij jou past.'],
        ['Kan ik voedingsadvies combineren met training?', 'Zeker. Voedingsadvies werkt het best samen met beweging, bijvoorbeeld met personal training of een van de groepslessen.'],
        ['Ik heb een medische aandoening, kan ik toch meedoen?', 'Bij medische klachten of een specifiek dieet (bijvoorbeeld bij diabetes of een voedselallergie) is een diëtist de aangewezen persoon. Twijfel je? Neem gerust contact op.'],
    ];
@endphp

<x-layouts.app :faqs="$faqs">
    <section class="relative overflow-hidden">
        <div class="container-site grid items-center gap-12 py-14 lg:min-h-[500px] lg:grid-cols-2 lg:py-10">
            <div>
                <p class="eyebrow">Voedingsadvies · Lansingerland</p>
                <h1 class="mt-4 text-[24px] font-semibold leading-tight">Gezond eten dat bij je leven past.</h1>
                <p class="mt-6 max-w-xl text-[15px] font-normal leading-relaxed text-[#333]">Praktisch voedingsadvies op maat, zonder ingewikkelde regels. Zodat je meer energie hebt, je doelen haalt en je training het maximale oplevert.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#aanvragen" class="btn btn-primary">Voedingsadvies aanvragen</a>
                    <a href="{{ route('caloriebehoefte-calculator') }}" class="btn btn-outline">Bereken je caloriebehoefte</a>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -inset-4 rotate-3 rounded-base bg-mint-500/20" aria-hidden="true"></div>
                <img src="{{ asset('images/bootcamp-outdoor.png') }}" alt="Gezond eten en buiten sporten" class="relative aspect-[4/3] w-full rounded-base object-cover lg:aspect-auto lg:h-[400px]">
            </div>
        </div>
    </section>

    <section class="container-site py-16">
        <p class="eyebrow">Waar kan ik je mee helpen?</p>
        <h2 class="mt-3 max-w-2xl text-3xl sm:text-4xl">Advies afgestemd op jouw doel</h2>
        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($topics as [$title, $text])
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
                <p class="eyebrow">Wat krijg je?</p>
                <h2 class="mt-3 text-3xl sm:text-4xl">Dit zit erin</h2>
                <ul class="mt-8 space-y-4">
                    @foreach ($includes as $item)
                        <li class="flex gap-3">
                            <span class="mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-full bg-mint-500 text-white">
                                <svg class="size-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-8 8a1 1 0 01-1.4 0l-4-4a1 1 0 111.4-1.4L8 12.58l7.3-7.3a1 1 0 011.4 0z" clip-rule="evenodd"/></svg>
                            </span>
                            <span class="text-gray-700">{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
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
                <h2 class="text-3xl">Vraag voedingsadvies aan</h2>
                <p class="mt-3 text-gray-600">Vertel waar je tegenaan loopt en wat je wilt bereiken. Ik neem zo snel mogelijk contact met je op.</p>
                <x-contact-form class="mt-6 space-y-5" source="voedings-advies" interest="Voedingsadvies" :show-interest="false" submit="Voedingsadvies aanvragen" />
            </div>
            <aside class="card h-fit p-8">
                <h2 class="text-xl">Ook interessant</h2>
                <ul class="mt-4 space-y-3 text-sm">
                    <li><a href="{{ route('afval-begeleiding') }}" class="font-semibold text-mint-600">Afvalbegeleiding →</a></li>
                    <li><a href="{{ route('training', 'personal-training') }}" class="font-semibold text-mint-600">Personal training →</a></li>
                    <li><a href="{{ route('caloriebehoefte-calculator') }}" class="font-semibold text-mint-600">Caloriebehoefte calculator →</a></li>
                </ul>
            </aside>
        </div>
    </section>
</x-layouts.app>
