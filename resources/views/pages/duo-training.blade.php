@php
    $benefits = [
        ['Samen sta je sterker', 'Met een trainingsmaatje sla je minder snel een training over. Jullie houden elkaar scherp en gemotiveerd.'],
        ['Persoonlijke aandacht', 'Met maar twee deelnemers krijg je bijna net zoveel begeleiding als bij personal training. Ik let op jullie techniek en stem de oefeningen op ieder van jullie af.'],
        ['Kosten delen', 'Je deelt de training, en daarmee ook de kosten. Zo krijg je training op maat voor minder dan een één-op-één-sessie.'],
        ['Op jullie tijd en plek', 'Jullie kiezen samen het moment en de locatie: in de natuur, in het park of bij jullie in de buurt. Alle materialen neem ik mee.'],
    ];

    $audiences = ['Partners die samen fitter willen worden', 'Vriendinnen of vrienden die een sportmaatje zoeken', 'Ouder en (volwassen) kind', 'Collega\'s die samen willen trainen', 'Iedereen die het gezelliger vindt om niet alleen te sporten'];

    $steps = [
        'Vraag hieronder een duo training aan en vertel wat jullie doelen zijn.',
        'We plannen een kennismaking en bespreken jullie niveau, wensen en de locatie.',
        'Jullie trainen samen, met een programma dat bij jullie allebei past.',
    ];

    $faqs = [
        ['Moeten we hetzelfde niveau hebben?', 'Nee. Ik pas oefeningen per persoon aan, dus jullie kunnen gewoon samen trainen, ook als de een fitter is dan de ander.'],
        ['Waar vindt de training plaats?', 'Op een locatie naar keuze in Lansingerland, Pijnacker of Nootdorp. Bijvoorbeeld in De Groenzoom, rond de Dobbeplas of bij jullie in de buurt.'],
        ['Wat moeten we meenemen?', 'Alleen goede sportschoenen, kleding voor buiten en water. Alle trainingsmaterialen neem ik mee.'],
        ['Wat kost een duo training?', 'De prijs hangt af van de trainingsduur en hoe vaak jullie willen trainen. Vraag vrijblijvend de mogelijkheden aan, dan krijg je een voorstel op maat.'],
    ];
@endphp

<x-layouts.app :faqs="$faqs">
    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="container-site grid items-center gap-12 py-14 lg:grid-cols-2 lg:py-24">
            <div>
                <p class="eyebrow">Duo training · Lansingerland</p>
                <h1 class="mt-4 text-4xl leading-tight sm:text-5xl lg:text-6xl">Samen trainen, dubbel zo leuk.</h1>
                <p class="mt-6 max-w-xl text-lg leading-relaxed text-gray-600">Train met z'n tweeën onder persoonlijke begeleiding in de buitenlucht. Met je partner, een vriend(in) of collega werk je aan kracht, conditie en jullie eigen doelen.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#aanvragen" class="btn btn-primary">Duo training aanvragen</a>
                    <a href="{{ route('training', 'personal-training') }}" class="btn btn-outline">Liever alleen?</a>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -inset-4 rotate-3 rounded-base bg-mint-500/20" aria-hidden="true"></div>
                <img src="{{ asset('images/personal-training.png') }}" alt="Duo training in de buitenlucht" class="relative aspect-[4/3] w-full rounded-base object-cover">
            </div>
        </div>
    </section>

    {{-- Voordelen --}}
    <section class="container-site py-16">
        <p class="eyebrow">Waarom duo training?</p>
        <h2 class="mt-3 max-w-2xl text-3xl sm:text-4xl">Het beste van personal training, samen met je sportmaatje</h2>
        <div class="mt-10 grid gap-5 sm:grid-cols-2">
            @foreach ($benefits as [$title, $text])
                <div class="card p-6">
                    <h3 class="text-xl">{{ $title }}</h3>
                    <p class="mt-2 leading-relaxed text-gray-600">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Voor wie + zo werkt het --}}
    <section class="bg-white py-16">
        <div class="container-site grid gap-12 lg:grid-cols-2">
            <div>
                <p class="eyebrow">Voor wie?</p>
                <h2 class="mt-3 text-3xl sm:text-4xl">Train met wie jij wilt</h2>
                <ul class="mt-8 space-y-4">
                    @foreach ($audiences as $audience)
                        <li class="flex gap-3">
                            <span class="mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-full bg-mint-500 text-white">
                                <svg class="size-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-8 8a1 1 0 01-1.4 0l-4-4a1 1 0 111.4-1.4L8 12.58l7.3-7.3a1 1 0 011.4 0z" clip-rule="evenodd"/></svg>
                            </span>
                            <span class="text-gray-700">{{ $audience }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <p class="eyebrow">Zo werkt het</p>
                <h2 class="mt-3 text-3xl sm:text-4xl">In drie stappen aan de slag</h2>
                <ol class="mt-8 space-y-5">
                    @foreach ($steps as $i => $step)
                        <li class="flex gap-4">
                            <span class="flex size-8 shrink-0 items-center justify-center rounded-full bg-mint-500 font-bold text-white">{{ $i + 1 }}</span>
                            <span class="pt-1 text-gray-700">{{ $step }}</span>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </section>

    {{-- Veelgestelde vragen --}}
    <section class="container-site py-16">
        <p class="eyebrow">Veelgestelde vragen</p>
        <h2 class="mt-3 text-3xl sm:text-4xl">Goed om te weten</h2>
        <div class="mt-8 max-w-3xl space-y-3">
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
    </section>

    {{-- Aanvraagformulier --}}
    <section id="aanvragen" class="scroll-mt-24 py-16">
        <div class="container-site grid gap-10 lg:grid-cols-[3fr_2fr]">
            <div class="card p-6 sm:p-8">
                <h2 class="text-3xl">Vraag een duo training aan</h2>
                <p class="mt-3 text-gray-600">Vertel wie je trainingsmaatje is en wat jullie willen bereiken. Ik neem zo snel mogelijk contact met je op.</p>
                <x-contact-form class="mt-6 space-y-5" source="duo-training" interest="Duo training" :show-interest="false" submit="Duo training aanvragen" />
            </div>
            <aside class="card h-fit p-8">
                <h2 class="text-xl">Liever eerst even bellen?</h2>
                <p class="mt-3 text-sm text-gray-600">Neem gerust contact op met {{ config('site.contact.person') }}.</p>
                <ul class="mt-6 space-y-3 text-sm">
                    <li><a href="tel:{{ preg_replace('/\s+/', '', config('site.contact.phone')) }}" class="font-semibold text-mint-600">{{ config('site.contact.phone') }}</a></li>
                    <li><a href="mailto:{{ config('site.contact.email') }}" class="font-semibold text-mint-600">{{ config('site.contact.email') }}</a></li>
                </ul>
            </aside>
        </div>
    </section>
</x-layouts.app>
