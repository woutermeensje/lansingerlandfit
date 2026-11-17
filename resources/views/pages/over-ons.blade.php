<x-layouts.app>
    <x-page-hero eyebrow="Over mij" title="Hoi, ik ben {{ config('site.contact.person') }}" intro="Oprichter en trainer van LansingerlandFit. Ik help je om met plezier buiten te sporten, op jouw niveau." />

    <section class="container-site grid gap-12 py-12 lg:grid-cols-[3fr_2fr]">
        <div class="prose-site text-lg">
            <p>Na mijn studie Rechtsgeleerdheid en een master Notarieel Recht werkte ik jarenlang als kandidaat-notaris en in juridische adviesfuncties. Sport was altijd al mijn uitlaatklep.</p>
            <p>Na de geboorte van mijn eerste dochter, Claire, veranderde mijn kijk op wat echt belangrijk is. Ik besloot mijn juridische carrière achter me te laten en mijn passie te volgen: mensen helpen om fitter, sterker en energieker te worden.</p>
            <p>Inmiddels ben ik moeder van drie kinderen en woon ik in Pijnacker, daarvoor in Berkel en Rodenrijs. Ik ken de mooiste plekken in de regio om buiten te trainen.</p>

            <h2>Mijn ervaring en opleiding</h2>
            <p>Mijn ervaring als sportinstructeur heb ik vooral in de praktijk opgedaan, door verschillende trainingen en groepslessen te verzorgen. Daarnaast verdiep ik me graag in sport, beweging en de menselijke anatomie.</p>
            <p>Ik heb geen algemene sportopleiding gevolgd, maar heb wel mijn officiële Les Mills BODYpump-certificaat behaald. Daarmee heb ik mijn praktijkervaring aangevuld met een certificering voor deze krachtgerichte groepsles.</p>

            <h2>Zo geef ik training</h2>
            <p>Mijn trainingen bij LansingerlandFit vinden buiten plaats. Ik zorg voor de materialen en bereid iedere les voor. Bij bootcamp stel ik iedere week een andere, uitdagende workout samen.</p>
            <p>Ik let op je houding en techniek en geef persoonlijke aanwijzingen. Waar nodig pas ik oefeningen aan op jouw niveau. Je hoeft niet de sterkste, snelste of meest ervaren sporter te zijn om mee te doen.</p>
            <p>Ik ben enthousiast, persoonlijk en motiverend. Er mag tijdens mijn lessen gelachen worden! Ik vind het belangrijk dat je je op je gemak voelt en met plezier terugkomt.</p>

            <h2>Waar ik voor sta</h2>
            <p>Plezier, persoonlijke aandacht, respect, discipline en betrouwbaarheid staan voor mij centraal. Je mag erop vertrouwen dat ik op tijd aanwezig ben en mijn lessen met aandacht voorbereid.</p>
            <p>Ik doe geen beloftes over hoeveel je afvalt, hoe snel je sterker wordt of welke resultaten je binnen een bepaalde periode behaalt. Dat hangt van veel verschillende factoren af, waaronder je eigen inzet.</p>
            <p>Ook privacy vind ik belangrijk. Ik publiceer geen foto's van deelnemers en deel geen persoonlijke informatie online zonder toestemming.</p>

            <h2>Wat je kunt verwachten</h2>
            <ul class="space-y-2">
                @foreach (config('site.usps') as $usp)
                    <li class="flex gap-3"><span class="text-mint-500" aria-hidden="true">●</span> {{ $usp }}</li>
                @endforeach
            </ul>
            <h2 id="groepslessen" class="scroll-mt-28">Ook beschikbaar als groepslesinstructeur</h2>
            <p>Naast mijn eigen buitentrainingen verzorg ik groepslessen binnen sportscholen. Ik heb ervaring met Pilates, Lower Body Boost, BBB (Buik, Billen, Benen), Kick &amp; Fun, Yogalates en Les Mills BODYpump.</p>
            <p>Zoek je voor je sportschool een enthousiaste groepslesinstructeur voor vaste lessen of invalwerk? <a href="{{ route('contact', ['interesse' => 'Groepslesinstructeur']) }}">Neem gerust contact met mij op</a>.</p>

            <h2 id="danspartner" class="scroll-mt-28">Salsa en bachata: beschikbaar als danspartner</h2>
            <p>In het verleden heb ik veel salsa en bachata gedanst. Dansen is voor mij een heerlijke combinatie van muziek, beweging, techniek en plezier.</p>
            <p>Dansscholen en dansinstructeurs kunnen mij benaderen als vrouwelijke danspartner (volger) om tijdens lessen te assisteren, als invaller of op vaste basis. <a href="{{ route('contact', ['interesse' => 'Danspartner salsa en bachata']) }}">Vraag naar de mogelijkheden</a>.</p>
        </div>

        <aside id="informatie" class="card h-fit p-6 sm:p-8 lg:sticky lg:top-28">
            <h2 class="text-2xl">Informatie aanvragen</h2>
            <p class="mt-2 text-sm text-gray-600">Heb je een vraag? Laat je gegevens achter en ik neem snel contact met je op.</p>
            <x-contact-form source="over-ons" :show-interest="false" class="mt-6 space-y-5" />
        </aside>
    </section>

    <section class="bg-white py-14">
        <div class="container-site">
            <h2 class="heading-2">Mijn trainingen</h2>
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach (\App\Support\Site::trainings() as $slug => $training)
                    <a href="{{ route('training', $slug) }}" class="rounded-base bg-navy-50 p-6 hover:bg-mint-100">
                        <h3 class="text-lg">{{ $training['title'] }}</h3>
                        <p class="mt-2 text-sm text-gray-600">{{ $training['short'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
