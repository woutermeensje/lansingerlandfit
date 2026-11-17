<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach (self::TRAINING_UPDATES as $slug => $fields) {
            foreach ($fields as $field => $values) {
                $before = $values['before'];
                $after = $values['after'];
                $training = DB::table('trainings')->where('slug', $slug)->first();

                if ($training === null) {
                    continue;
                }

                $current = is_array($before) ? json_decode($training->{$field}, true) : $training->{$field};

                if ($current !== $before) {
                    continue;
                }

                DB::table('trainings')->where('id', $training->id)->update([
                    $field => is_array($after) ? json_encode($after, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR) : $after,
                    'updated_at' => now(),
                ]);
            }
        }

        foreach (self::PRICES as $price) {
            if (DB::table('prices')->where('title', $price['title'])->orWhere('interest', $price['interest'])->exists()) {
                continue;
            }

            DB::table('prices')->insert([
                ...$price,
                'features' => json_encode($price['features'], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $bootcampId = DB::table('trainings')->where('slug', 'bootcamp-outdoor')->value('id');

        if ($bootcampId !== null) {
            DB::table('lessons')->where('training_id', $bootcampId)
                ->where('name', 'Bootcamp Outdoor')
                ->where(function (Builder $query): void {
                    $query->where(fn (Builder $query): Builder => $query->where('day', 5)->where('location', 'Berkel en Rodenrijs'))
                        ->orWhere(fn (Builder $query): Builder => $query->where('day', 7)->where('location', 'Pijnacker'));
                })
                ->update([
                    'location' => 'Achter de Daltonschool, Ackerswoude, Pijnacker',
                    'updated_at' => now(),
                ]);
        }
    }

    /**
     * Behoud de inhoud bij een rollback: deze kan inmiddels via de admin zijn aangepast.
     */
    public function down(): void {}

    /**
     * Alleen oorspronkelijke standaardteksten vervangen; bewerkingen via de admin blijven behouden.
     */
    private const TRAINING_UPDATES = [
        'bootcamp-outdoor' => [
            'intro' => [
                'before' => 'Afwisselende groepstrainingen in de buitenlucht waarin kracht en cardio samenkomen. Elke les is anders en je traint op je eigen niveau.',
                'after' => 'Een afwisselende en intensieve groepsles in de buitenlucht waarbij alle spiergroepen aan bod komen. Ik stel iedere week een nieuwe workout samen.',
            ],
            'body' => [
                'before' => ['Tijdens de Outdoor Bootcamp train je met een kleine groep in de natuur van Lansingerland en Pijnacker. We combineren krachtoefeningen, conditietraining en functionele bewegingen, met je eigen lichaamsgewicht en eenvoudige materialen.', 'De trainingen zijn geschikt voor iedereen: beginners krijgen een lichtere variant, gevorderden worden extra uitgedaagd. Zo werk je in je eigen tempo aan een fitter en sterker lichaam.'],
                'after' => ['Tijdens de trainingen combineren we verschillende kracht- en conditieoefeningen. Ik zorg voor alle benodigde materialen en geef persoonlijke aanwijzingen bij de uitvoering.', 'Iedere week bereid ik een andere workout voor. Waar nodig pas ik oefeningen aan op het niveau van de deelnemers. Zo blijft de training uitdagend, afwisselend en leuk.'],
            ],
            'benefits' => [
                'before' => ['Kracht én conditie', 'Wisselende oefeningen', 'Geschikt voor ieder niveau', 'Kleine groepen'],
                'after' => ['Kracht en conditie', 'Iedere week een nieuwe workout', 'Aandacht voor je techniek', 'Alle materialen aanwezig'],
            ],
            'seo_description' => [
                'before' => 'Outdoor bootcamp in kleine groepen in Berkel en Rodenrijs en Pijnacker. Kracht en conditie in de buitenlucht, voor ieder niveau. Gratis proefles!',
                'after' => 'Bootcamp Outdoor met Cindy: afwisselende kracht- en conditieoefeningen buiten, met persoonlijke aanwijzingen en alle materialen. Probeer een gratis les.',
            ],
        ],
        'xco-walking' => [
            'short' => [
                'before' => 'Powerwalking met XCO\'s in de natuur voor een sterker en fitter lichaam.',
                'after' => 'Buiten wandelen en oefeningen doen, in een actieve en gezellige groep.',
            ],
            'intro' => [
                'before' => 'Fitnesswandelen met XCO-tubes: je traint armen, schouders, core en benen tegelijk, terwijl je stevig doorwandelt.',
                'after' => 'XCO Walking combineert wandelen met oefeningen in de buitenlucht. Een actieve en gezellige manier om aan je conditie en spierkracht te werken.',
            ],
            'body' => [
                'before' => ['XCO Walking is powerwalking met speciale tubes die met een korrelvulling gevuld zijn. Door de reactieve kracht van de vulling train je bij elke beweging je bovenlichaam en core mee.', 'Het is een low-impact training: vriendelijk voor je gewrichten, maar wel intensief. Ideaal als je wilt werken aan je conditie, houding en spierkracht zonder te hoeven hardlopen.'],
                'after' => ['XCO Walking is een actieve groepsles in de buitenlucht waarbij wandelen wordt gecombineerd met oefeningen.', 'De lessen zijn geschikt als je graag buiten beweegt en op een actieve, gezellige manier wilt sporten, zonder direct aan een intensieve bootcamp deel te nemen.'],
            ],
            'benefits' => [
                'before' => ['Low-impact', 'Hele lichaam traint mee', 'Heerlijk in de natuur', 'XCO\'s worden verzorgd'],
                'after' => ['Wandelen en oefeningen combineren', 'Werken aan conditie en spierkracht', 'Buiten bewegen', 'Samen sporten in een gezellige groep'],
            ],
            'seo_description' => [
                'before' => 'Powerwalking met XCO-tubes in De Groenzoom en rond de Dobbeplas. Low-impact training voor kracht, conditie en houding. Probeer een gratis proefles.',
                'after' => 'XCO Walking bij LansingerlandFit: wandelen en oefeningen in de buitenlucht. Werk in een gezellige groep aan conditie en spierkracht. Gratis proefles.',
            ],
        ],
        'zwangerschapsfitness' => [
            'short' => [
                'before' => 'Veilig en verantwoord in beweging blijven tijdens je zwangerschap.',
                'after' => 'Persoonlijke één-op-één begeleiding tijdens je zwangerschap, in de buitenlucht.',
            ],
            'intro' => [
                'before' => 'Trainen in kleine groepen in de buitenlucht, speciaal voor zwangere vrouwen. Veilig, verantwoord en als voorbereiding op de bevalling.',
                'after' => 'Persoonlijke één-op-één begeleiding voor zwangere vrouwen. Ik stem de oefeningen af op jouw wensen, belastbaarheid en de fase van je zwangerschap.',
            ],
            'body' => [
                'before' => ['Tijdens je zwangerschap verandert je lichaam voortdurend. Met zwangerschapsfitness blijf je op een veilige manier fit en sterk, met oefeningen die zijn afgestemd op elk trimester.', 'We werken aan je conditie, houding, bekkenbodem en ademhaling. Daarnaast is het een fijne manier om andere aanstaande moeders te ontmoeten.'],
                'after' => ['Iedere zwangerschap is anders. Daarom kijken we samen naar jouw wensen, mogelijkheden en hoe je je voelt. Je traint één-op-één met mij, in de buitenlucht.', 'De oefeningen worden afgestemd op je belastbaarheid en de fase van je zwangerschap. Het doel is om op een prettige en verantwoorde manier actief te blijven, met aandacht voor je lichaam en een goede uitvoering.'],
            ],
            'benefits' => [
                'before' => ['Afgestemd per trimester', 'Kleine groepen', 'Buiten in de frisse lucht', 'Voorbereiding op de bevalling'],
                'after' => ['Eén-op-één begeleiding', 'Afgestemd op jouw belastbaarheid', 'Aandacht voor de uitvoering', 'Trainen in de buitenlucht'],
            ],
            'interest' => [
                'before' => 'Zwangerschapstraining',
                'after' => 'Zwangerschapsfitness',
            ],
            'seo_description' => [
                'before' => 'Veilig fit blijven tijdens je zwangerschap met buitentrainingen in kleine groepen, afgestemd per trimester. In Lansingerland, Pijnacker en Nootdorp.',
                'after' => 'Zwangerschapsfitness met persoonlijke één-op-één begeleiding in de buitenlucht. Oefeningen afgestemd op jouw belastbaarheid en de fase van je zwangerschap.',
            ],
        ],
        'personal-training' => [
            'intro' => [
                'before' => 'Eén-op-één begeleiding gericht op jouw doel: afvallen, sterker worden, herstel of een betere conditie.',
                'after' => 'Bij personal training draait alles om jou. We kijken samen naar je doelen, je huidige niveau en de manier waarop je graag wilt trainen.',
            ],
            'body' => [
                'before' => ['Bij personal training staat jouw doel centraal. Samen bepalen we waar je naartoe wilt werken en stellen we een trainingsplan op maat op.', 'Je kiest zelf de locatie: in de natuur bij jou in de buurt, in het park of bij je thuis. Alle materialen worden meegenomen, jij hoeft alleen jezelf mee te brengen.'],
                'after' => ['Of je nu sterker wilt worden, je conditie wilt verbeteren of behoefte hebt aan extra motivatie en begeleiding: ik help je graag op weg.', 'Tijdens de trainingen in de buitenlucht let ik goed op je houding en techniek. Waar nodig pas ik oefeningen aan en werken we samen aan een betere uitvoering.'],
            ],
            'benefits' => [
                'before' => ['Eén-op-één begeleiding', 'Trainingsduur naar keuze', 'Bij jou in de buurt', 'Alle materialen aanwezig'],
                'after' => ['Eén-op-één begeleiding', 'Afgestemd op jouw doelen en niveau', 'Aandacht voor houding en techniek', 'Trainen in de buitenlucht'],
            ],
            'seo_description' => [
                'before' => 'Personal training op maat in Lansingerland, Pijnacker en Nootdorp. Eén-op-één begeleiding bij jou in de buurt, gericht op afvallen, kracht of conditie.',
                'after' => 'Personal training met Cindy in Lansingerland en Pijnacker. Eén-op-één buiten trainen op jouw niveau, met aandacht voor je doelen, houding en techniek.',
            ],
        ],
        'bedrijfsbootcamp' => [
            'intro' => [
                'before' => 'Outdoor bootcamps voor medewerkers, op of rond jullie eigen bedrijfslocatie. Goed voor de gezondheid én de teamspirit.',
                'after' => 'Sportieve en uitdagende buitentrainingen voor bedrijven. Samen met collega\'s bewegen op een afgesproken locatie, met materialen, muziek en motivatie.',
            ],
            'body' => [
                'before' => ['Met een bedrijfsbootcamp investeer je in gezonde, energieke medewerkers. De trainingen vinden plaats op een locatie naar keuze, bijvoorbeeld vlak bij kantoor, voor of na werktijd of in de lunchpauze.', 'Elke training is geschikt voor alle niveaus, zodat iedereen kan meedoen. Je ontvangt een offerte op maat, afhankelijk van het aantal deelnemers, de frequentie en de locatie.'],
                'after' => ['Ik kom naar een afgesproken locatie, meestal op het terrein van het bedrijf zelf. Ik neem alle benodigde materialen mee, zorg voor muziek en motiveer de deelnemers.', 'De trainingen worden afgestemd op de deelnemers en de wensen van het bedrijf. Een leuke manier om samen actief bezig te zijn en elkaar op een andere manier te leren kennen.', 'Je ontvangt een offerte op maat. De prijs hangt af van het aantal deelnemers, de lesfrequentie, de locatie, de duur van de sessies, het type training en het gebruik van materialen.'],
            ],
            'benefits' => [
                'before' => ['Op locatie naar keuze', 'Voor alle niveaus', 'Versterkt de teamspirit', 'Offerte op maat'],
                'after' => ['Op een afgesproken locatie', 'Afgestemd op de deelnemers', 'Materialen en muziek worden verzorgd', 'Offerte op maat'],
            ],
        ],
        'seniorensport' => [
            'intro' => [
                'before' => 'Seniorenfit: in beweging blijven met kracht- en cardiotraining die is afgestemd op senioren.',
                'after' => 'Groepslessen in de buitenlucht voor wie op latere leeftijd actief wil blijven. We werken op een toegankelijke manier aan spierkracht, balans en conditie.',
            ],
            'body' => [
                'before' => ['Bij Seniorenfit train je in een kleine, gezellige groep in de buitenlucht. We werken aan kracht, balans, conditie en mobiliteit, zodat je fit en zelfstandig blijft.', 'De oefeningen worden aangepast aan wat jij kunt. Plezier en gezondheid staan voorop.'],
                'after' => ['Bij seniorensport werken we in de buitenlucht aan beweging, spierkracht, balans en conditie. Ik verzorg alle benodigde materialen en houd rekening met je niveau en mogelijkheden.', 'De lessen zijn bedoeld voor mensen die graag actief blijven, maar voor wie een intensieve bootcamp minder goed aansluit bij hun wensen.'],
            ],
        ],
    ];

    private const PRICES = [
        [
            'title' => 'Zwangerschapsfitness',
            'price' => '€ 49,-',
            'unit' => 'per uur',
            'extra' => null,
            'features' => ['Persoonlijke één-op-één begeleiding', 'Afgestemd op je belastbaarheid', 'Aandacht voor de uitvoering', 'Training in de buitenlucht', 'Gratis proefles'],
            'cta' => 'Zwangerschapsfitness aanvragen',
            'interest' => 'Zwangerschapsfitness',
            'highlight' => false,
            'sort_order' => 4,
        ],
        [
            'title' => 'Seniorensport',
            'price' => '€ 15,-',
            'unit' => 'per les',
            'extra' => '10-rittenkaart € 140,-',
            'features' => ['Groepsles in de buitenlucht', 'Spierkracht, balans en conditie', 'Oefeningen afgestemd op je mogelijkheden', 'Alle materialen aanwezig', 'Gratis proefles'],
            'cta' => 'Seniorensport aanvragen',
            'interest' => 'Seniorensport',
            'highlight' => false,
            'sort_order' => 5,
        ],
        [
            'title' => 'Duo Training',
            'price' => 'Op aanvraag',
            'unit' => null,
            'extra' => null,
            'features' => ['Samen sporten met een bekende', 'Persoonlijke begeleiding', 'Afgestemd op jullie niveau en doelen', 'Prijs afhankelijk van duur en frequentie'],
            'cta' => 'Duo training aanvragen',
            'interest' => 'Duo training',
            'highlight' => false,
            'sort_order' => 6,
        ],
    ];
};
