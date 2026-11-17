<x-layouts.app>
    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="container-site grid items-center gap-12 py-14 lg:min-h-[500px] lg:grid-cols-2 lg:py-10">
            <div>
                <p class="eyebrow">Lansingerlandfit.nl</p>
                <h1 class="mt-4 heading-1">Buiten sporten in Lansingerland, Pijnacker en Nootdorp.</h1>
                <p class="mt-6 max-w-xl text-[15px] font-normal leading-relaxed text-[#333]">Ik ben Cindy. Bij LansingerlandFit train je buiten, met persoonlijke aandacht en ruimte voor gezelligheid. Kies een groepsles, personal training of train samen met een bekende.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('proefles') }}" class="btn btn-primary">Gratis proefles</a>
                    <a href="{{ route('lesrooster') }}" class="btn btn-outline">Lesrooster</a>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -inset-4 rotate-3 rounded-base bg-mint-500/20" aria-hidden="true"></div>
                <img src="{{ asset('images/personal-training.png') }}" alt="Personal training in de buitenlucht" class="relative aspect-[4/3] w-full rounded-base object-cover lg:aspect-auto lg:h-[400px]">
            </div>
        </div>
    </section>

    {{-- Uitgelichte trainingen --}}
    <section class="container-site py-16">
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ($featured as $slug => $training)
                <x-training-card :slug="$slug" :training="$training" />
            @endforeach
        </div>
    </section>

    {{-- Intro --}}
    <section class="container-site grid gap-12 py-10 lg:grid-cols-2">
        <div>
            <p class="eyebrow">Lansingerlandfit.nl</p>
            <h2 class="mt-3 heading-2">Vind een manier van sporten die bij je past</h2>
        </div>
        <div class="prose-site">
            <p>Sporten is voor mij lekker bewegen, mijn hoofd leegmaken en nieuwe energie opdoen. Dat plezier deel ik graag met jou. Mijn trainingen bij LansingerlandFit vinden allemaal buiten plaats.</p>
            <p>Je hoeft niet de sterkste, snelste of meest ervaren sporter te zijn. Ik kijk naar jouw wensen en niveau en help je een training te vinden die je graag blijft doen.</p>
        </div>
    </section>

    {{-- Onze lessen --}}
    <section class="container-site py-16">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="eyebrow">Mijn aanbod</p>
                <h2 class="mt-3 heading-2">Welke training past bij jou?</h2>
                <p class="mt-3 max-w-xl text-gray-600">Benieuwd wanneer en waar we trainen? Bekijk het <a href="{{ route('lesrooster') }}" class="font-semibold text-mint-600 underline underline-offset-4">complete lesrooster</a>.</p>
            </div>
            <a href="{{ route('trainingen') }}" class="btn btn-navy self-start sm:self-auto">Alle trainingen</a>
        </div>

        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($trainings as $slug => $training)
                <a href="{{ route('training', $slug) }}" class="card group p-6 transition hover:bg-navy-700">
                    <h3 class="text-xl group-hover:!text-white">{{ $training['title'] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-gray-600 group-hover:text-navy-100">{{ $training['intro'] }}</p>
                    <span class="mt-4 inline-block text-sm font-semibold text-mint-600 group-hover:text-mint-400">Lees meer &rarr;</span>
                </a>
                @if ($slug === 'personal-training')
                    <a href="{{ route('duo-training') }}" class="card group p-6 transition hover:bg-navy-700">
                        <h3 class="text-xl group-hover:!text-white">Duo Training</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600 group-hover:text-navy-100">Sport samen met een bekende. Ik stem de training af op jullie wensen, niveau en doelen.</p>
                        <span class="mt-4 inline-block text-sm font-semibold text-mint-600 group-hover:text-mint-400">Lees meer &rarr;</span>
                    </a>
                @endif
            @endforeach
        </div>
    </section>

    {{-- USP's --}}
    <section class="bg-white py-16">
        <div class="container-site grid items-center gap-12 lg:grid-cols-2">
            <img src="{{ asset('images/xco-walking.png') }}" alt="XCO Walking in de buitenlucht" loading="lazy" class="aspect-[3/2] w-full rounded-base object-cover">
            <div>
                <p class="eyebrow">Waarom LansingerlandFit?</p>
                <h2 class="mt-3 heading-2">Sporten met plezier en persoonlijke aandacht</h2>
                <ul class="mt-8 space-y-4">
                    @foreach (config('site.usps') as $usp)
                        <li class="flex gap-3">
                            <span class="mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-full bg-mint-500 text-white">
                                <svg class="size-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-8 8a1 1 0 01-1.4 0l-4-4a1 1 0 111.4-1.4L8 12.58l7.3-7.3a1 1 0 011.4 0z" clip-rule="evenodd"/></svg>
                            </span>
                            <span class="text-gray-700">{{ $usp }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
</x-layouts.app>
