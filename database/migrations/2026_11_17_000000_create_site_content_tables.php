<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Trainingen, lesrooster en tarieven stonden in config/site.php en zijn nu
 * via /admin te beheren. Deze migratie maakt de tabellen aan en vult ze met
 * de inhoud die op dat moment in de config stond.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('image')->nullable();
            $table->string('card_image')->nullable();
            $table->string('short', 500);
            $table->text('intro');
            $table->json('body');
            $table->json('benefits');
            $table->string('interest')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 500)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('day');
            $table->string('name');
            $table->string('starts_at', 5);
            $table->string('ends_at', 5);
            $table->string('location');
            $table->timestamps();
        });

        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('price');
            $table->string('unit')->nullable();
            $table->string('extra')->nullable();
            $table->json('features');
            $table->string('cta');
            $table->string('interest')->nullable();
            $table->boolean('highlight')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $now = now();

        foreach (self::TRAININGS as $training) {
            DB::table('trainings')->insert([
                ...$training,
                'body' => json_encode($training['body'], JSON_UNESCAPED_UNICODE),
                'benefits' => json_encode($training['benefits'], JSON_UNESCAPED_UNICODE),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $ids = DB::table('trainings')->pluck('id', 'slug');

        foreach (self::LESSONS as $lesson) {
            DB::table('lessons')->insert([
                'training_id' => $ids[$lesson['training']],
                ...collect($lesson)->except('training')->all(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        foreach (self::PRICES as $price) {
            DB::table('prices')->insert([
                ...$price,
                'features' => json_encode($price['features'], JSON_UNESCAPED_UNICODE),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('prices');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('trainings');
    }

    private const TRAININGS = [
        [
            'slug' => 'bootcamp-outdoor',
            'title' => 'Bootcamp Outdoor',
            'image' => 'images/bootcamp-outdoor.png',
            'card_image' => null,
            'short' => 'Kracht en conditie in de buitenlucht, in een gemotiveerde groep.',
            'intro' => 'Afwisselende groepstrainingen in de buitenlucht waarin kracht en cardio samenkomen. Elke les is anders en je traint op je eigen niveau.',
            'body' => [
                'Tijdens de Outdoor Bootcamp train je met een kleine groep in de natuur van Lansingerland en Pijnacker. We combineren krachtoefeningen, conditietraining en functionele bewegingen, met je eigen lichaamsgewicht en eenvoudige materialen.',
                'De trainingen zijn geschikt voor iedereen: beginners krijgen een lichtere variant, gevorderden worden extra uitgedaagd. Zo werk je in je eigen tempo aan een fitter en sterker lichaam.',
            ],
            'benefits' => [
                'Kracht én conditie',
                'Wisselende oefeningen',
                'Geschikt voor ieder niveau',
                'Kleine groepen',
            ],
            'interest' => 'Bootcamp Outdoor',
            'seo_title' => 'Bootcamp Outdoor in Lansingerland en Pijnacker',
            'seo_description' => 'Outdoor bootcamp in kleine groepen in Berkel en Rodenrijs en Pijnacker. Kracht en conditie in de buitenlucht, voor ieder niveau. Gratis proefles!',
            'sort_order' => 1,
        ],
        [
            'slug' => 'xco-walking',
            'title' => 'Xco Walking',
            'image' => 'images/xco-walking.png',
            'card_image' => 'images/xco-walking-card.png',
            'short' => 'Powerwalking met XCO\'s in de natuur voor een sterker en fitter lichaam.',
            'intro' => 'Fitnesswandelen met XCO-tubes: je traint armen, schouders, core en benen tegelijk, terwijl je stevig doorwandelt.',
            'body' => [
                'XCO Walking is powerwalking met speciale tubes die met een korrelvulling gevuld zijn. Door de reactieve kracht van de vulling train je bij elke beweging je bovenlichaam en core mee.',
                'Het is een low-impact training: vriendelijk voor je gewrichten, maar wel intensief. Ideaal als je wilt werken aan je conditie, houding en spierkracht zonder te hoeven hardlopen.',
            ],
            'benefits' => [
                'Low-impact',
                'Hele lichaam traint mee',
                'Heerlijk in de natuur',
                'XCO\'s worden verzorgd',
            ],
            'interest' => 'XCO Walking',
            'seo_title' => 'Xco Walking in Berkel en Rodenrijs en Nootdorp',
            'seo_description' => 'Powerwalking met XCO-tubes in De Groenzoom en rond de Dobbeplas. Low-impact training voor kracht, conditie en houding. Probeer een gratis proefles.',
            'sort_order' => 2,
        ],
        [
            'slug' => 'zwangerschapsfitness',
            'title' => 'Zwangerschapsfitness',
            'image' => 'images/zwangerschapsfitness.png',
            'card_image' => null,
            'short' => 'Veilig en verantwoord in beweging blijven tijdens je zwangerschap.',
            'intro' => 'Trainen in kleine groepen in de buitenlucht, speciaal voor zwangere vrouwen. Veilig, verantwoord en als voorbereiding op de bevalling.',
            'body' => [
                'Tijdens je zwangerschap verandert je lichaam voortdurend. Met zwangerschapsfitness blijf je op een veilige manier fit en sterk, met oefeningen die zijn afgestemd op elk trimester.',
                'We werken aan je conditie, houding, bekkenbodem en ademhaling. Daarnaast is het een fijne manier om andere aanstaande moeders te ontmoeten.',
            ],
            'benefits' => [
                'Afgestemd per trimester',
                'Kleine groepen',
                'Buiten in de frisse lucht',
                'Voorbereiding op de bevalling',
            ],
            'interest' => 'Zwangerschapstraining',
            'seo_title' => 'Zwangerschapsfitness in Lansingerland',
            'seo_description' => 'Veilig fit blijven tijdens je zwangerschap met buitentrainingen in kleine groepen, afgestemd per trimester. In Lansingerland, Pijnacker en Nootdorp.',
            'sort_order' => 3,
        ],
        [
            'slug' => 'personal-training',
            'title' => 'Personal Training',
            'image' => 'images/personal-training.png',
            'card_image' => null,
            'short' => 'Persoonlijke training volledig afgestemd op jouw doelen en niveau.',
            'intro' => 'Eén-op-één begeleiding gericht op jouw doel: afvallen, sterker worden, herstel of een betere conditie.',
            'body' => [
                'Bij personal training staat jouw doel centraal. Samen bepalen we waar je naartoe wilt werken en stellen we een trainingsplan op maat op.',
                'Je kiest zelf de locatie: in de natuur bij jou in de buurt, in het park of bij je thuis. Alle materialen worden meegenomen, jij hoeft alleen jezelf mee te brengen.',
            ],
            'benefits' => [
                'Eén-op-één begeleiding',
                'Trainingsduur naar keuze',
                'Bij jou in de buurt',
                'Alle materialen aanwezig',
            ],
            'interest' => 'Personal training',
            'seo_title' => 'Personal training in Lansingerland en Pijnacker',
            'seo_description' => 'Personal training op maat in Lansingerland, Pijnacker en Nootdorp. Eén-op-één begeleiding bij jou in de buurt, gericht op afvallen, kracht of conditie.',
            'sort_order' => 4,
        ],
        [
            'slug' => 'bedrijfsbootcamp',
            'title' => 'Bedrijfsbootcamp',
            'image' => 'images/bedrijfsbootcamp.png',
            'card_image' => null,
            'short' => 'Samen met collega\'s werken aan kracht, conditie en een fitter team.',
            'intro' => 'Outdoor bootcamps voor medewerkers, op of rond jullie eigen bedrijfslocatie. Goed voor de gezondheid én de teamspirit.',
            'body' => [
                'Met een bedrijfsbootcamp investeer je in gezonde, energieke medewerkers. De trainingen vinden plaats op een locatie naar keuze, bijvoorbeeld vlak bij kantoor, voor of na werktijd of in de lunchpauze.',
                'Elke training is geschikt voor alle niveaus, zodat iedereen kan meedoen. Je ontvangt een offerte op maat, afhankelijk van het aantal deelnemers, de frequentie en de locatie.',
            ],
            'benefits' => [
                'Op locatie naar keuze',
                'Voor alle niveaus',
                'Versterkt de teamspirit',
                'Offerte op maat',
            ],
            'interest' => 'Bedrijfsbootcamp',
            'seo_title' => 'Bedrijfsbootcamp voor teams in Lansingerland',
            'seo_description' => 'Outdoor bedrijfsbootcamp op of bij jullie bedrijfslocatie in Lansingerland en omgeving. Fittere medewerkers en een betere teamspirit. Offerte op maat.',
            'sort_order' => 5,
        ],
        [
            'slug' => 'seniorensport',
            'title' => 'Seniorensport',
            'image' => null,
            'card_image' => null,
            'short' => 'Kracht- en cardiotraining voor senioren, in een gezellige groep.',
            'intro' => 'Seniorenfit: in beweging blijven met kracht- en cardiotraining die is afgestemd op senioren.',
            'body' => [
                'Bij Seniorenfit train je in een kleine, gezellige groep in de buitenlucht. We werken aan kracht, balans, conditie en mobiliteit, zodat je fit en zelfstandig blijft.',
                'De oefeningen worden aangepast aan wat jij kunt. Plezier en gezondheid staan voorop.',
            ],
            'benefits' => [
                'Kracht en balans',
                'Aangepast aan jouw niveau',
                'Gezellige groep',
                'Buiten in de natuur',
            ],
            'interest' => 'Seniorensport',
            'seo_title' => 'Seniorensport en Seniorenfit in Lansingerland',
            'seo_description' => 'Seniorenfit: kracht-, balans- en conditietraining voor senioren in een gezellige groep, buiten in Berkel en Rodenrijs en Nootdorp. Train gratis mee.',
            'sort_order' => 6,
        ],
    ];

    private const LESSONS = [
        [
            'training' => 'seniorensport',
            'day' => 1,
            'name' => 'Seniorenfit',
            'starts_at' => '09:30',
            'ends_at' => '10:30',
            'location' => 'Natuurgebied De Groenzoom, Berkel en Rodenrijs',
        ],
        [
            'training' => 'seniorensport',
            'day' => 2,
            'name' => 'Seniorenfit',
            'starts_at' => '11:30',
            'ends_at' => '12:30',
            'location' => 'Dobbeplas, Nootdorp',
        ],
        [
            'training' => 'xco-walking',
            'day' => 3,
            'name' => 'Xco Walking',
            'starts_at' => '18:30',
            'ends_at' => '19:30',
            'location' => 'De Groenzoom, Berkel en Rodenrijs',
        ],
        [
            'training' => 'seniorensport',
            'day' => 4,
            'name' => 'Seniorenfit',
            'starts_at' => '10:00',
            'ends_at' => '11:00',
            'location' => 'De Groenzoom, Berkel en Rodenrijs',
        ],
        [
            'training' => 'xco-walking',
            'day' => 5,
            'name' => 'Xco Walking',
            'starts_at' => '08:30',
            'ends_at' => '09:30',
            'location' => 'Dobbeplas, Nootdorp',
        ],
        [
            'training' => 'seniorensport',
            'day' => 5,
            'name' => 'Seniorenfit',
            'starts_at' => '10:00',
            'ends_at' => '11:00',
            'location' => 'Dobbeplas, Nootdorp',
        ],
        [
            'training' => 'bootcamp-outdoor',
            'day' => 5,
            'name' => 'Bootcamp Outdoor',
            'starts_at' => '18:30',
            'ends_at' => '19:30',
            'location' => 'Berkel en Rodenrijs',
        ],
        [
            'training' => 'bootcamp-outdoor',
            'day' => 7,
            'name' => 'Bootcamp Outdoor',
            'starts_at' => '08:30',
            'ends_at' => '09:30',
            'location' => 'Pijnacker',
        ],
    ];

    private const PRICES = [
        [
            'title' => 'Bootcamp Outdoor',
            'price' => '€ 17,50',
            'unit' => 'per les*',
            'extra' => '10-rittenkaart € 160,-',
            'features' => [
                'Training in de buitenlucht',
                '1 uur training',
                'Geen inschrijfgeld',
                'Verschillende locaties',
                'Kracht én conditie',
                'Gratis proefles',
            ],
            'cta' => 'Groepsles aanvragen',
            'interest' => 'Bootcamp Outdoor',
            'highlight' => false,
            'sort_order' => 1,
        ],
        [
            'title' => 'XCO Walking',
            'price' => '€ 12,50',
            'unit' => 'per les*',
            'extra' => '10-rittenkaart € 110,-',
            'features' => [
                'Training in de buitenlucht',
                '1 uur training',
                'Geen inschrijfgeld',
                'Verschillende locaties',
                'Powerwalking met XCO\'s',
                'Gratis proefles',
            ],
            'cta' => 'Groepsles aanvragen',
            'interest' => 'XCO Walking',
            'highlight' => true,
            'sort_order' => 2,
        ],
        [
            'title' => 'Personal Training',
            'price' => '€ 59,-',
            'unit' => 'per uur*',
            'extra' => null,
            'features' => [
                'Eén-op-één begeleiding',
                'Trainingsduur naar keuze',
                'Bij jou in de buurt',
                'Geen inschrijfgeld',
                'Gericht op persoonlijke doelen',
                'Training op maat',
            ],
            'cta' => 'Personal Training aanvragen',
            'interest' => 'Personal training',
            'highlight' => false,
            'sort_order' => 3,
        ],
    ];
};
