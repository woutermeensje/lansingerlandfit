<?php

/*
|--------------------------------------------------------------------------
| Inhoud van Lansingerlandfit.nl
|--------------------------------------------------------------------------
|
| Vaste teksten, locaties en contactgegevens staan hier
| op één plek. Trainingen, lesrooster en tarieven staan in de database.
|
*/

return [

    'name' => 'Lansingerlandfit.nl',
    'tagline' => 'Buiten sporten in Lansingerland, Pijnacker en Nootdorp.',

    'contact' => [
        'person' => 'Cindy van der Starre',
        'email' => env('SITE_CONTACT_EMAIL', 'cindystarre@hotmail.com'),
        'phone' => env('SITE_CONTACT_PHONE', '06 34049481'),
        // Ontvanger van notificaties van alle formulieren (contact, proefles, duo-training, reserveringen).
        'notify' => env('ADMIN_EMAIL', env('SITE_CONTACT_EMAIL', 'cindystarre@hotmail.com')),
        'cc' => env('CONTACT_EMAIL'),
    ],

    'regions' => ['Lansingerland', 'Pijnacker', 'Nootdorp', 'Berkel en Rodenrijs', 'Bergschenhoek', 'Bleiswijk'],

    /*
    | Trainingen, lesrooster en tarieven staan in de database en zijn te
    | beheren via /admin. Dag 1 = maandag ... 7 = zondag (ISO).
    */
    'days' => [1 => 'Maandag', 2 => 'Dinsdag', 3 => 'Woensdag', 4 => 'Donderdag', 5 => 'Vrijdag', 6 => 'Zaterdag', 7 => 'Zondag'],

    'trainer' => 'Cindy van der Starre',

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

    /*
    | Buitensportplekken in en rond Lansingerland (pagina /sportparken-lansingerland).
    */
    'parks' => [
        [
            'title' => 'De Groenzoom',
            'place' => 'Berkel en Rodenrijs',
            'text' => 'Ruim natuur- en recreatiegebied met brede paden, open velden en waterpartijen. Hier trainen we op maandag, woensdag, donderdag en vrijdag.',
            'activities' => ['Bootcamp Outdoor', 'Xco Walking', 'Seniorenfit'],
            'image' => 'images/locatie-berkel-en-rodenrijs.png',
        ],
        [
            'title' => 'Dobbeplas',
            'place' => 'Nootdorp',
            'text' => 'Recreatieplas met een rondje van een paar kilometer, ideaal om te wandelen, hardlopen en buiten te trainen. Hier trainen we op dinsdag en vrijdag.',
            'activities' => ['Xco Walking', 'Seniorenfit'],
            'image' => 'images/locatie-nootdorp.jpg',
        ],
        [
            'title' => 'Hoge Bergse Bos',
            'place' => 'Bergschenhoek',
            'text' => 'Heuvelachtig bos- en recreatiegebied: met zijn hellingen een van de weinige plekken in de regio waar je echt hoogtemeters kunt maken.',
            'activities' => ['Hardlopen', 'Heuveltraining', 'Wandelen'],
            'image' => 'images/bootcamp-outdoor.png',
        ],
        [
            'title' => 'Rottemeren',
            'place' => 'Bleiswijk',
            'text' => 'Uitgestrekt recreatiegebied langs het water met lange fiets- en wandelpaden. Perfect voor een duurloop of een lange wandeling.',
            'activities' => ['Hardlopen', 'Fietsen', 'Wandelen'],
            'image' => 'images/xco-walking.png',
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

    'interests' => ['XCO Walking', 'Bootcamp Outdoor', 'Personal training', 'Duo training', 'Afvalbegeleiding', 'Voedingsadvies', 'Bedrijfsbootcamp', 'Zwangerschapstraining', 'Seniorensport', 'Gratis proefles', 'Anders, namelijk'],

];
