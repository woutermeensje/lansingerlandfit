<x-layouts.app>
    <x-page-hero eyebrow="Over mij" title="Hoi, ik ben {{ config('site.contact.person') }}" intro="Oprichter en trainer van LansingerlandFit. Ik help je om met plezier buiten te sporten, op jouw niveau." />

    <section class="container-site grid gap-12 py-12 lg:grid-cols-[3fr_2fr]">
        <div class="prose-site text-lg">
            <p>Na mijn studie Rechtsgeleerdheid en een master Notarieel Recht werkte ik jarenlang als kandidaat-notaris en in juridische adviesfuncties. Sport was altijd al mijn uitlaatklep.</p>
            <p>Na de geboorte van mijn eerste dochter, Claire, veranderde mijn kijk op wat echt belangrijk is. Ik besloot mijn juridische carrière achter me te laten en mijn passie te volgen: mensen helpen om fitter, sterker en gelukkiger te worden.</p>
            <p>Inmiddels ben ik moeder van drie kinderen en woon ik in Pijnacker, daarvoor in Berkel en Rodenrijs. Ik ken de mooiste plekken in de regio om buiten te trainen.</p>

            <h2>Over ons</h2>
            <p>Bij LansingerlandFit geloven we dat sporten voor iedereen toegankelijk, leuk en effectief moet zijn. Met lokale kennis van Lansingerland, Pijnacker en Nootdorp bieden we trainingen in de natuur, dicht bij huis.</p>

            <h2>Waarom kiezen voor LansingerlandFit?</h2>
            <ul class="space-y-2">
                @foreach (config('site.usps') as $usp)
                    <li class="flex gap-3"><span class="text-mint-500" aria-hidden="true">●</span> {{ $usp }}</li>
                @endforeach
            </ul>
            <p>Ik zie je graag bij een van de trainingen!</p>
        </div>

        <aside id="informatie" class="card h-fit p-6 sm:p-8 lg:sticky lg:top-28">
            <h2 class="text-2xl">Informatie aanvragen</h2>
            <p class="mt-2 text-sm text-gray-600">Heb je een vraag? Laat je gegevens achter en ik neem snel contact met je op.</p>
            <x-contact-form source="over-ons" :show-interest="false" class="mt-6 space-y-5" />
        </aside>
    </section>

    <section class="bg-white py-14">
        <div class="container-site">
            <h2 class="text-3xl">Onze trainingen</h2>
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach (config('site.trainings') as $slug => $training)
                    <a href="{{ route('training', $slug) }}" class="rounded-base bg-navy-50 p-6 hover:bg-mint-100">
                        <h3 class="text-lg">{{ $training['title'] }}</h3>
                        <p class="mt-2 text-sm text-gray-600">{{ $training['short'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
