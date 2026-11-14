@php
    $activities = [
        '1.2' => ['Zittend', 'Weinig tot geen beweging, kantoorwerk'],
        '1.375' => ['Licht actief', '1 à 3 keer per week sporten of dagelijks wandelen'],
        '1.55' => ['Gemiddeld actief', '3 à 5 keer per week sporten'],
        '1.725' => ['Zeer actief', '6 à 7 keer per week sporten of lichamelijk zwaar werk'],
        '1.9' => ['Extreem actief', 'Dagelijks intensief trainen én lichamelijk zwaar werk'],
    ];

    $goals = [
        'lose' => 'Afvallen',
        'maintain' => 'Op gewicht blijven',
        'gain' => 'Aankomen',
    ];

    $paces = [
        'slow' => 'Rustig',
        'normal' => 'Gemiddeld',
        'fast' => 'Snel',
    ];

    $faqs = [
        ['Hoe wordt mijn caloriebehoefte berekend?', 'Eerst berekenen we je ruststofwisseling (BMR): de energie die je lichaam in volledige rust verbruikt. Daarvoor gebruiken we de Mifflin-St Jeor-formule, die wetenschappelijk gezien de meest betrouwbare schatting geeft voor volwassenen. Vul je je vetpercentage in, dan gebruiken we de Katch-McArdle-formule, die rekening houdt met je vetvrije massa. De BMR vermenigvuldigen we met je activiteitsfactor. Zo krijg je je totale dagelijkse energieverbruik (TDEE).'],
        ['Hoe nauwkeurig is de uitkomst?', 'Het is een goede schatting, maar geen exacte waarde. Erfelijkheid, spiermassa, hormonen, slaap en stress spelen ook mee. Gebruik de uitkomst als startpunt, houd je gewicht 2 à 3 weken bij en stel daarna bij met 100 à 200 kcal per dag.'],
        ['Hoeveel calorieën moet ik eten om af te vallen?', 'Een kilo lichaamsvet staat gelijk aan ongeveer 7.700 kcal. Met een tekort van 500 kcal per dag val je dus zo\'n 0,5 kilo per week af. Dat is een gezond tempo dat je goed volhoudt. De calculator adviseert nooit minder dan 1.200 kcal (vrouwen) of 1.500 kcal (mannen) per dag.'],
        ['Hoeveel calorieën heb ik nodig om aan te komen?', 'Wil je aankomen of spiermassa opbouwen, dan werkt een klein overschot van 250 à 500 kcal per dag het best, in combinatie met krachttraining. Een groter overschot leidt vooral tot extra vetopslag.'],
        ['Waarom is eiwit zo belangrijk?', 'Eiwit helpt je spiermassa te behouden tijdens het afvallen en op te bouwen als je traint. Het verzadigt bovendien goed. Daarom adviseert de calculator 1,6 tot 2 gram eiwit per kilo lichaamsgewicht, afhankelijk van je doel.'],
        ['Voor wie is deze calculator niet geschikt?', 'De calculator is bedoeld voor gezonde volwassenen. Ben je zwanger, geef je borstvoeding, ben je jonger dan 18 of heb je een medische aandoening? Overleg dan met je huisarts, verloskundige of een diëtist.'],
    ];
@endphp

<x-layouts.app :faqs="$faqs">
    <x-page-hero eyebrow="Gratis tool" title="Caloriebehoefte calculator" intro="Bereken in een minuut hoeveel calorieën jij per dag nodig hebt: om af te vallen, op gewicht te blijven of aan te komen. Voor mannen en vrouwen, op basis van wetenschappelijk onderbouwde formules." />

    <section class="container-site grid items-start gap-8 py-12 lg:grid-cols-[3fr_2fr]">
        {{-- Invoer --}}
        <form class="card space-y-8 p-6 sm:p-8" data-calorie-calculator novalidate>
            <div class="space-y-5">
                <h2 class="calc-step"><span>1</span> Over jou</h2>

                <fieldset>
                    <legend class="form-label">Geslacht</legend>
                    <div class="form-choices">
                        <label class="form-choice"><input type="radio" name="sex" value="female" checked> Vrouw</label>
                        <label class="form-choice"><input type="radio" name="sex" value="male"> Man</label>
                    </div>
                </fieldset>

                <div class="grid gap-5 sm:grid-cols-3">
                    <div>
                        <label for="calc-age" class="form-label">Leeftijd <span class="form-unit">(jaar)</span></label>
                        <input id="calc-age" name="age" type="number" inputmode="numeric" min="18" max="100" required class="form-input" placeholder="35">
                    </div>
                    <div>
                        <label for="calc-height" class="form-label">Lengte <span class="form-unit">(cm)</span></label>
                        <input id="calc-height" name="height" type="number" inputmode="numeric" min="130" max="230" required class="form-input" placeholder="170">
                    </div>
                    <div>
                        <label for="calc-weight" class="form-label">Gewicht <span class="form-unit">(kg)</span></label>
                        <input id="calc-weight" name="weight" type="number" inputmode="decimal" min="35" max="250" step="0.1" required class="form-input" placeholder="70">
                    </div>
                </div>

                <details class="form-optional">
                    <summary>Ken je je vetpercentage? <span class="form-unit">(optioneel, voor een nauwkeurigere berekening)</span></summary>
                    <div class="mt-4 max-w-48">
                        <label for="calc-bodyfat" class="form-label">Vetpercentage <span class="form-unit">(%)</span></label>
                        <input id="calc-bodyfat" name="bodyfat" type="number" inputmode="decimal" min="5" max="60" step="0.1" class="form-input" placeholder="25">
                    </div>
                </details>
            </div>

            <fieldset class="space-y-4">
                <legend class="calc-step"><span>2</span> Hoe actief ben je?</legend>
                <div class="grid gap-2">
                    @foreach ($activities as $factor => [$label, $hint])
                        <label class="form-option">
                            <input type="radio" name="activity" value="{{ $factor }}" @checked($factor === '1.375')>
                            <span>
                                <span class="form-option__title">{{ $label }}</span>
                                <span class="form-option__hint">{{ $hint }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>
            </fieldset>

            <div class="space-y-5">
                <fieldset>
                    <legend class="calc-step"><span>3</span> Wat is je doel?</legend>
                    <div class="form-choices mt-4">
                        @foreach ($goals as $value => $label)
                            <label class="form-choice"><input type="radio" name="goal" value="{{ $value }}" @checked($value === 'lose')> {{ $label }}</label>
                        @endforeach
                    </div>
                </fieldset>

                <fieldset data-calc-pace>
                    <legend class="form-label">Tempo</legend>
                    <div class="form-choices">
                        @foreach ($paces as $value => $label)
                            <label class="form-choice"><input type="radio" name="pace" value="{{ $value }}" @checked($value === 'normal')> {{ $label }} <span class="form-unit" data-calc-pace-hint="{{ $value }}"></span></label>
                        @endforeach
                    </div>
                </fieldset>
            </div>

            <p class="form-error hidden" data-calc-error role="alert">Vul een geldige leeftijd (18–100), lengte (130–230 cm) en gewicht (35–250 kg) in.</p>

            <button type="submit" class="btn btn-primary w-full sm:w-auto">Bereken mijn caloriebehoefte</button>
        </form>

        {{-- Uitkomst --}}
        <aside id="uitkomst" class="card scroll-mt-28 p-6 sm:p-8 lg:sticky lg:top-28" aria-live="polite">
            <div data-calc-empty>
                <p class="eyebrow">Jouw uitkomst</p>
                <h2 class="mt-2 text-2xl">Hoeveel calorieën heb jij nodig?</h2>
                <p class="mt-3 text-gray-600">Vul je leeftijd, lengte en gewicht in. De uitkomst verschijnt hier direct en past zich aan terwijl je je gegevens wijzigt.</p>
            </div>

            <div class="hidden" data-calc-result>
                <p class="eyebrow" data-calc-goal-label>Om af te vallen</p>
                <p class="mt-2 text-5xl font-bold tracking-tight text-navy-700 sm:text-6xl"><span data-calc-target>0</span> <span class="text-lg font-semibold text-gray-500">kcal per dag</span></p>
                <p class="mt-2 text-sm font-medium text-mint-600" data-calc-change></p>
                <p class="form-error mt-4 hidden" data-calc-floor></p>

                {{-- Alle doelen --}}
                <div class="mt-6 grid grid-cols-3 gap-2 text-center">
                    @foreach ($goals as $value => $label)
                        <div class="rounded-base border border-line p-3" data-calc-goal-tile="{{ $value }}">
                            <p class="text-xs text-gray-500">{{ $label }}</p>
                            <p class="mt-1 text-lg font-bold text-navy-700" data-calc-goal-kcal="{{ $value }}">0</p>
                        </div>
                    @endforeach
                </div>

                {{-- Macro's --}}
                <div class="mt-8">
                    <h3 class="text-base">Verdeling per dag</h3>
                    <div class="mt-3 flex h-3 overflow-hidden rounded-full bg-navy-50" aria-hidden="true">
                        <span class="bg-navy-700" data-calc-bar="protein"></span>
                        <span class="bg-mint-500" data-calc-bar="carbs"></span>
                        <span class="bg-mint-400/50" data-calc-bar="fat"></span>
                    </div>
                    <dl class="mt-4 grid grid-cols-3 gap-2 text-sm">
                        <div><dt class="flex items-center gap-1.5 text-gray-600"><span class="size-2 rounded-full bg-navy-700"></span>Eiwit</dt><dd class="mt-0.5 font-semibold text-navy-700"><span data-calc-macro="protein">0</span> g</dd></div>
                        <div><dt class="flex items-center gap-1.5 text-gray-600"><span class="size-2 rounded-full bg-mint-500"></span>Koolhydraten</dt><dd class="mt-0.5 font-semibold text-navy-700"><span data-calc-macro="carbs">0</span> g</dd></div>
                        <div><dt class="flex items-center gap-1.5 text-gray-600"><span class="size-2 rounded-full bg-mint-400/50"></span>Vet</dt><dd class="mt-0.5 font-semibold text-navy-700"><span data-calc-macro="fat">0</span> g</dd></div>
                    </dl>
                </div>

                {{-- Details --}}
                <dl class="mt-8 space-y-3 border-t border-line pt-6 text-sm">
                    <div class="flex justify-between gap-4"><dt class="text-gray-600">Ruststofwisseling (BMR)</dt><dd class="font-semibold text-navy-700"><span data-calc-bmr>0</span> kcal</dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-gray-600">Totaal verbruik (TDEE)</dt><dd class="font-semibold text-navy-700"><span data-calc-tdee>0</span> kcal</dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-gray-600">BMI</dt><dd class="font-semibold text-navy-700"><span data-calc-bmi>0</span> <span class="font-normal text-gray-500" data-calc-bmi-label></span></dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-gray-600">Formule</dt><dd class="font-semibold text-navy-700" data-calc-formula>Mifflin-St Jeor</dd></div>
                </dl>

                <div class="mt-8 rounded-base bg-mint-100 p-5">
                    <p class="font-semibold text-navy-700">Hulp nodig om dit vol te houden?</p>
                    <p class="mt-1 text-sm text-gray-600">Met persoonlijke begeleiding en training op maat haal je je doel makkelijker.</p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('afval-begeleiding') }}" class="btn btn-primary">Afvalbegeleiding</a>
                        <a href="{{ route('voedings-advies') }}" class="btn btn-outline">Voedingsadvies</a>
                    </div>
                </div>
            </div>
        </aside>
    </section>

    {{-- Uitleg --}}
    <section class="bg-white py-16">
        <div class="container-site">
            <p class="eyebrow">Zo werkt het</p>
            <h2 class="mt-3 max-w-2xl text-3xl sm:text-4xl">Hoe wordt je caloriebehoefte berekend?</h2>
            <div class="mt-10 grid gap-5 md:grid-cols-3">
                <div class="card p-6">
                    <p class="text-3xl font-bold text-mint-500">1</p>
                    <h3 class="mt-2 text-xl">Ruststofwisseling</h3>
                    <p class="mt-2 leading-relaxed text-gray-600">Wat je lichaam in rust verbruikt voor ademhaling, hartslag en lichaamstemperatuur. Dit is meestal 60 à 70% van je totale verbruik.</p>
                </div>
                <div class="card p-6">
                    <p class="text-3xl font-bold text-mint-500">2</p>
                    <h3 class="mt-2 text-xl">Activiteit</h3>
                    <p class="mt-2 leading-relaxed text-gray-600">Je ruststofwisseling keer je activiteitsfactor (1,2 tot 1,9) geeft je totale dagelijkse energieverbruik: je onderhoudsniveau.</p>
                </div>
                <div class="card p-6">
                    <p class="text-3xl font-bold text-mint-500">3</p>
                    <h3 class="mt-2 text-xl">Je doel</h3>
                    <p class="mt-2 leading-relaxed text-gray-600">Om af te vallen eet je 250 à 750 kcal minder, om aan te komen 250 à 500 kcal meer dan je onderhoudsniveau.</p>
                </div>
            </div>

            <div class="mt-12 grid gap-12 lg:grid-cols-2">
                <div class="prose-site">
                    <h2>De formules</h2>
                    <p><strong>Mifflin-St Jeor</strong> (standaard)<br>
                        Vrouwen: 10 × gewicht + 6,25 × lengte − 5 × leeftijd − 161<br>
                        Mannen: 10 × gewicht + 6,25 × lengte − 5 × leeftijd + 5</p>
                    <p><strong>Katch-McArdle</strong> (als je je vetpercentage invult)<br>
                        370 + 21,6 × vetvrije massa in kg</p>
                    <p>Calorieën zijn een belangrijk startpunt, maar niet het hele verhaal. De kwaliteit van je voeding, voldoende eiwit, goed slapen en regelmatig bewegen maken het verschil. Daar help ik je graag bij.</p>
                    <p class="text-sm text-gray-500">Deze calculator geeft een schatting en is geen medisch advies.</p>
                </div>
                <div>
                    <h2 class="text-2xl">Veelgestelde vragen</h2>
                    <div class="mt-6 space-y-3">
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
        </div>
    </section>
</x-layouts.app>
