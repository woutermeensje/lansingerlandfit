<?php

/*
|--------------------------------------------------------------------------
| Inhoud van Lansingerlandfit.nl
|--------------------------------------------------------------------------
|
| Alle teksten, trainingen, het lesrooster, tarieven en locaties staan hier
| op één plek, zodat de views alleen nog presentatie bevatten.
|
*/

return [

    'name' => 'Lansingerlandfit.nl',
    'tagline' => 'Buiten sporten in Lansingerland, Pijnacker en Nootdorp.',

    'contact' => [
        'person' => 'Cindy van der Starre',
        'email' => env('SITE_CONTACT_EMAIL', 'info@lansingerlandfit.nl'),
        'phone' => env('SITE_CONTACT_PHONE', '06 34049481'),
        // Ontvanger van contactformulieren en reserveringen.
        'notify' => env('SITE_NOTIFY_EMAIL', env('SITE_CONTACT_EMAIL', 'info@lansingerlandfit.nl')),
    ],

    'regions' => ['Lansingerland', 'Pijnacker', 'Nootdorp', 'Berkel en Rodenrijs', 'Bergschenhoek', 'Bleiswijk'],

    /*
    | Trainingen. De slug is ook de URL (gelijk aan de oude WordPress-site).
    */
    'trainings' => [
        'bootcamp-outdoor' => [
            'title' => 'Bootcamp Outdoor',
            'image' => 'images/bootcamp-outdoor.png',
            'short' => 'Kracht en conditie in de buitenlucht, in een gemotiveerde groep.',
            'intro' => 'Afwisselende groepstrainingen in de buitenlucht waarin kracht en cardio samenkomen. Elke les is anders en je traint op je eigen niveau.',
            'body' => [
                'Tijdens de Outdoor Bootcamp train je met een kleine groep in de natuur van Lansingerland en Pijnacker. We combineren krachtoefeningen, conditietraining en functionele bewegingen, met je eigen lichaamsgewicht en eenvoudige materialen.',
                'De trainingen zijn geschikt voor iedereen: beginners krijgen een lichtere variant, gevorderden worden extra uitgedaagd. Zo werk je in je eigen tempo aan een fitter en sterker lichaam.',
            ],
            'benefits' => ['Kracht én conditie', 'Wisselende oefeningen', 'Geschikt voor ieder niveau', 'Kleine groepen'],
            'interest' => 'Bootcamp Outdoor',
        ],
        'xco-walking' => [
            'title' => 'Xco Walking',
            'image' => 'images/xco-walking.png',
            'card_image' => 'images/xco-walking-card.png',
            'short' => 'Powerwalking met XCO\'s in de natuur voor een sterker en fitter lichaam.',
            'intro' => 'Fitnesswandelen met XCO-tubes: je traint armen, schouders, core en benen tegelijk, terwijl je stevig doorwandelt.',
            'body' => [
                'XCO Walking is powerwalking met speciale tubes die met een korrelvulling gevuld zijn. Door de reactieve kracht van de vulling train je bij elke beweging je bovenlichaam en core mee.',
                'Het is een low-impact training: vriendelijk voor je gewrichten, maar wel intensief. Ideaal als je wilt werken aan je conditie, houding en spierkracht zonder te hoeven hardlopen.',
            ],
            'benefits' => ['Low-impact', 'Hele lichaam traint mee', 'Heerlijk in de natuur', 'XCO\'s worden verzorgd'],
            'interest' => 'XCO Walking',
        ],
        'zwangerschapsfitness' => [
            'title' => 'Zwangerschapsfitness',
            'image' => 'images/zwangerschapsfitness.png',
            'short' => 'Veilig en verantwoord in beweging blijven tijdens je zwangerschap.',
            'intro' => 'Trainen in kleine groepen in de buitenlucht, speciaal voor zwangere vrouwen. Veilig, verantwoord en als voorbereiding op de bevalling.',
            'body' => [
                'Tijdens je zwangerschap verandert je lichaam voortdurend. Met zwangerschapsfitness blijf je op een veilige manier fit en sterk, met oefeningen die zijn afgestemd op elk trimester.',
                'We werken aan je conditie, houding, bekkenbodem en ademhaling. Daarnaast is het een fijne manier om andere aanstaande moeders te ontmoeten.',
            ],
            'benefits' => ['Afgestemd per trimester', 'Kleine groepen', 'Buiten in de frisse lucht', 'Voorbereiding op de bevalling'],
            'interest' => 'Zwangerschapstraining',
        ],
        'personal-training' => [
            'title' => 'Personal Training',
            'image' => 'images/personal-training.png',
            'short' => 'Persoonlijke training volledig afgestemd op jouw doelen en niveau.',
            'intro' => 'Eén-op-één begeleiding gericht op jouw doel: afvallen, sterker worden, herstel of een betere conditie.',
            'body' => [
                'Bij personal training staat jouw doel centraal. Samen bepalen we waar je naartoe wilt werken en stellen we een trainingsplan op maat op.',
                'Je kiest zelf de locatie: in de natuur bij jou in de buurt, in het park of bij je thuis. Alle materialen worden meegenomen, jij hoeft alleen jezelf mee te brengen.',
            ],
            'benefits' => ['Eén-op-één begeleiding', 'Trainingsduur naar keuze', 'Bij jou in de buurt', 'Alle materialen aanwezig'],
            'interest' => 'Personal training',
        ],
        'bedrijfsbootcamp' => [
            'title' => 'Bedrijfsbootcamp',
            'image' => 'images/bedrijfsbootcamp.png',
            'short' => 'Samen met collega\'s werken aan kracht, conditie en een fitter team.',
            'intro' => 'Outdoor bootcamps voor medewerkers, op of rond jullie eigen bedrijfslocatie. Goed voor de gezondheid én de teamspirit.',
            'body' => [
                'Met een bedrijfsbootcamp investeer je in gezonde, energieke medewerkers. De trainingen vinden plaats op een locatie naar keuze, bijvoorbeeld vlak bij kantoor, voor of na werktijd of in de lunchpauze.',
                'Elke training is geschikt voor alle niveaus, zodat iedereen kan meedoen. Je ontvangt een offerte op maat, afhankelijk van het aantal deelnemers, de frequentie en de locatie.',
            ],
            'benefits' => ['Op locatie naar keuze', 'Voor alle niveaus', 'Versterkt de teamspirit', 'Offerte op maat'],
            'interest' => 'Bedrijfsbootcamp',
        ],
        'seniorensport' => [
            'title' => 'Seniorensport',
            'image' => null,
            'short' => 'Kracht- en cardiotraining voor senioren, in een gezellige groep.',
            'intro' => 'Seniorenfit: in beweging blijven met kracht- en cardiotraining die is afgestemd op senioren.',
            'body' => [
                'Bij Seniorenfit train je in een kleine, gezellige groep in de buitenlucht. We werken aan kracht, balans, conditie en mobiliteit, zodat je fit en zelfstandig blijft.',
                'De oefeningen worden aangepast aan wat jij kunt. Plezier en gezondheid staan voorop.',
            ],
            'benefits' => ['Kracht en balans', 'Aangepast aan jouw niveau', 'Gezellige groep', 'Buiten in de natuur'],
            'interest' => 'Seniorensport',
        ],
    ],

    /*
    | Wekelijks lesrooster. Dag 1 = maandag ... 7 = zondag (ISO).
    */
    'schedule' => [
        ['id' => 'ma-seniorenfit', 'day' => 1, 'training' => 'seniorensport', 'name' => 'Seniorenfit', 'from' => '09:30', 'to' => '10:30', 'location' => 'Natuurgebied De Groenzoom, Berkel en Rodenrijs'],
        ['id' => 'di-seniorenfit', 'day' => 2, 'training' => 'seniorensport', 'name' => 'Seniorenfit', 'from' => '11:30', 'to' => '12:30', 'location' => 'Dobbeplas, Nootdorp'],
        ['id' => 'wo-xco', 'day' => 3, 'training' => 'xco-walking', 'name' => 'Xco Walking', 'from' => '18:30', 'to' => '19:30', 'location' => 'De Groenzoom, Berkel en Rodenrijs'],
        ['id' => 'do-seniorenfit', 'day' => 4, 'training' => 'seniorensport', 'name' => 'Seniorenfit', 'from' => '10:00', 'to' => '11:00', 'location' => 'De Groenzoom, Berkel en Rodenrijs'],
        ['id' => 'vr-xco', 'day' => 5, 'training' => 'xco-walking', 'name' => 'Xco Walking', 'from' => '08:30', 'to' => '09:30', 'location' => 'Dobbeplas, Nootdorp'],
        ['id' => 'vr-seniorenfit', 'day' => 5, 'training' => 'seniorensport', 'name' => 'Seniorenfit', 'from' => '10:00', 'to' => '11:00', 'location' => 'Dobbeplas, Nootdorp'],
        ['id' => 'vr-bootcamp', 'day' => 5, 'training' => 'bootcamp-outdoor', 'name' => 'Bootcamp Outdoor', 'from' => '18:30', 'to' => '19:30', 'location' => 'Berkel en Rodenrijs'],
        ['id' => 'zo-bootcamp', 'day' => 7, 'training' => 'bootcamp-outdoor', 'name' => 'Bootcamp Outdoor', 'from' => '08:30', 'to' => '09:30', 'location' => 'Pijnacker'],
    ],

    'days' => [1 => 'Maandag', 2 => 'Dinsdag', 3 => 'Woensdag', 4 => 'Donderdag', 5 => 'Vrijdag', 6 => 'Zaterdag', 7 => 'Zondag'],

    'trainer' => 'Cindy van der Starre',

    'prices' => [
        [
            'title' => 'Bootcamp Outdoor',
            'price' => '€ 17,50',
            'unit' => 'per les*',
            'extra' => '10-rittenkaart € 160,-',
            'features' => ['Training in de buitenlucht', '1 uur training', 'Geen inschrijfgeld', 'Verschillende locaties', 'Kracht én conditie', 'Gratis proefles'],
            'cta' => 'Groepsles aanvragen',
            'interest' => 'Bootcamp Outdoor',
        ],
        [
            'title' => 'XCO Walking',
            'price' => '€ 12,50',
            'unit' => 'per les*',
            'extra' => '10-rittenkaart € 110,-',
            'features' => ['Training in de buitenlucht', '1 uur training', 'Geen inschrijfgeld', 'Verschillende locaties', 'Powerwalking met XCO\'s', 'Gratis proefles'],
            'cta' => 'Groepsles aanvragen',
            'interest' => 'XCO Walking',
            'highlight' => true,
        ],
        [
            'title' => 'Personal Training',
            'price' => '€ 59,-',
            'unit' => 'per uur*',
            'extra' => null,
            'features' => ['Eén-op-één begeleiding', 'Trainingsduur naar keuze', 'Bij jou in de buurt', 'Geen inschrijfgeld', 'Gericht op persoonlijke doelen', 'Training op maat'],
            'cta' => 'Personal Training aanvragen',
            'interest' => 'Personal training',
        ],
    ],

    'locations' => [
        'bergschenhoek' => [
            'title' => 'Bergschenhoek',
            'image' => 'images/bootcamp-outdoor.png',
            'intro' => 'Buiten sporten in Bergschenhoek, in de groene omgeving van Lansingerland.',
        ],
        'berkel-en-rodenrijs' => [
            'title' => 'Berkel en Rodenrijs',
            'image' => 'images/locatie-berkel-en-rodenrijs.png',
            'intro' => 'We trainen in natuurgebied De Groenzoom. Verzamelen op de parkeerplaats bij de Groenzoom.',
        ],
        'nootdorp' => [
            'title' => 'Nootdorp',
            'image' => 'images/locatie-nootdorp.jpg',
            'intro' => 'Trainen rondom de Dobbeplas in Nootdorp, een prachtige plek om buiten te sporten.',
        ],
        'pijnacker' => [
            'title' => 'Pijnacker',
            'image' => 'images/locatie-nootdorp.jpg',
            'intro' => 'Buiten sporten in Pijnacker, met de bootcamp op zondagochtend.',
        ],
    ],

    'usps' => [
        'Persoonlijke begeleiding door een ervaren instructrice',
        'Sporten in de frisse buitenlucht',
        'Geschikt voor ieder niveau',
        'Kleine groepen met persoonlijke aandacht',
        'Actief in Lansingerland, Pijnacker en Nootdorp',
        'Focus op plezier, gezondheid en duurzame resultaten',
    ],

    'interests' => ['XCO Walking', 'Bootcamp Outdoor', 'Personal training', 'Bedrijfsbootcamp', 'Zwangerschapstraining', 'Seniorensport', 'Gratis proefles', 'Anders, namelijk'],

];
