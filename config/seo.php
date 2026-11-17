<?php

/*
|--------------------------------------------------------------------------
| SEO van Lansingerlandfit.nl
|--------------------------------------------------------------------------
|
| Eén plek voor alle paginatitels, SEO-titels en metabeschrijvingen. De
| layout, sitemap.xml, de HTML-sitemap (/sitemap) en robots.txt lezen hier
| allemaal uit.
|
| - name:        korte paginanaam (broodkruimels, HTML-sitemap)
| - title:       SEO-titel. " | Lansingerlandfit.nl" wordt automatisch
|                toegevoegd zolang de titel dan niet langer is dan 60 tekens.
| - description: metabeschrijving, bij voorkeur 120-155 tekens.
| - image:       deelafbeelding (og:image), optioneel.
| - updated:     datum van de laatste inhoudelijke wijziging (lastmod).
|
*/

return [

    // Alleen productie mag geïndexeerd worden; staging/lokaal krijgt noindex.
    'indexable' => (bool) env('SEO_INDEXABLE', env('APP_ENV') === 'production'),

    'brand' => 'Lansingerlandfit.nl',
    'separator' => ' | ',
    'max_title' => 60,
    'default_image' => 'images/personal-training.png',
    'updated' => '2026-11-17',

    /*
    | Vaste pagina's, op routenaam. De volgorde is ook de volgorde in de
    | HTML-sitemap.
    */
    'pages' => [
        'home' => [
            'name' => 'Home',
            'group' => 'Algemeen',
            'title' => 'Lansingerlandfit.nl | Buiten sporten in Lansingerland',
            'brand' => false,
            'description' => 'Bootcamp, Xco Walking, personal training en seniorensport in de buitenlucht in Lansingerland, Pijnacker en Nootdorp. Plan een gratis proefles!',
        ],
        'trainingen' => [
            'name' => 'Trainingen',
            'group' => 'Algemeen',
            'title' => 'Trainingen buiten in Lansingerland',
            'description' => 'Bootcamp, Xco Walking, personal training, zwangerschapsfitness, seniorensport en bedrijfsbootcamps buiten in Lansingerland, Pijnacker en Nootdorp.',
        ],
        'lesrooster' => [
            'name' => 'Lesrooster',
            'group' => 'Algemeen',
            'title' => 'Lesrooster groepslessen buiten',
            'description' => 'Bekijk het weekrooster van Bootcamp Outdoor, Xco Walking en Seniorenfit in Berkel en Rodenrijs, Nootdorp en Pijnacker en meld je direct aan.',
        ],
        'tarieven' => [
            'name' => 'Tarieven',
            'group' => 'Algemeen',
            'title' => 'Tarieven bootcamp en personal training',
            'description' => 'Tarieven voor bootcamp, XCO Walking, zwangerschapsfitness, personal training, duo training en seniorensport. Een proefles is altijd gratis.',
        ],
        'proefles' => [
            'name' => 'Gratis proefles',
            'group' => 'Algemeen',
            'title' => 'Gratis proefles buiten sporten',
            'description' => 'Train een keer gratis en vrijblijvend mee met Bootcamp Outdoor, Xco Walking of Seniorenfit in Lansingerland, Pijnacker of Nootdorp.',
        ],
        'over-ons' => [
            'name' => 'Over mij',
            'group' => 'Algemeen',
            'title' => 'Over trainer Cindy van der Starre',
            'description' => 'Maak kennis met Cindy van der Starre, oprichter en trainer van Lansingerlandfit.nl. Persoonlijke begeleiding bij buiten sporten in Lansingerland.',
        ],
        'contact' => [
            'name' => 'Contact',
            'group' => 'Algemeen',
            'title' => 'Contact opnemen',
            'description' => 'Vragen over groepslessen, personal training of een bedrijfsbootcamp? Neem contact op met Cindy via het formulier, telefoon of e-mail.',
        ],
        'duo-training' => [
            'name' => 'Duo training',
            'group' => 'Begeleiding',
            'title' => 'Duo training in Lansingerland',
            'description' => 'Duo training in Lansingerland, Pijnacker en Nootdorp: train samen met je partner, vriend of collega onder persoonlijke begeleiding in de buitenlucht.',
            'image' => 'images/personal-training.png',
        ],
        'caloriebehoefte-calculator' => [
            'name' => 'Caloriebehoefte calculator',
            'group' => 'Informatie en tools',
            'title' => 'Caloriebehoefte calculator: bereken het gratis',
            'description' => 'Bereken gratis je dagelijkse caloriebehoefte. Ontdek hoeveel calorieën je nodig hebt om af te vallen, op gewicht te blijven of spiermassa op te bouwen.',
        ],
        'sportparken' => [
            'name' => 'Sportparken Lansingerland',
            'group' => 'Informatie en tools',
            'title' => 'Sportparken in Lansingerland',
            'description' => 'De mooiste plekken om buiten te sporten in Lansingerland, Pijnacker en Nootdorp: van De Groenzoom tot de Dobbeplas. Ontdek waar je kunt trainen.',
            'image' => 'images/locatie-berkel-en-rodenrijs.png',
        ],
        'blogs' => [
            'name' => 'Blogs',
            'group' => 'Informatie en tools',
            'title' => 'Blog: tips over buiten sporten',
            'description' => 'Tips, inspiratie en verhalen over buiten sporten, gezond eten en fit blijven in Lansingerland, van trainer Cindy van der Starre.',
        ],
        'sitemap' => [
            'name' => 'Sitemap',
            'group' => 'Informatie en tools',
            'title' => 'Sitemap',
            'description' => 'Overzicht van alle pagina\'s op Lansingerlandfit.nl: trainingen, locaties, tarieven, begeleiding, handige tools en blogs.',
        ],
    ],

    /*
    | Locatiepagina's, op slug (zie config/site.php).
    */
    'locations' => [
        'bergschenhoek' => [
            'title' => 'Buiten sporten in Bergschenhoek',
            'description' => 'Bootcamp, personal training en buitentrainingen in Bergschenhoek, in de groene omgeving van Lansingerland. Bekijk de mogelijkheden en train gratis mee.',
        ],
        'berkel-en-rodenrijs' => [
            'title' => 'Buiten sporten in Berkel en Rodenrijs',
            'description' => 'XCO Walking op woensdag van 18:30 tot 19:30 uur en seniorensport in De Groenzoom, Berkel en Rodenrijs. Bekijk het rooster en probeer een gratis les.',
        ],
        'nootdorp' => [
            'title' => 'Buiten sporten in Nootdorp',
            'description' => 'Seniorensport rond de Dobbeplas in Nootdorp. Buiten bewegen met persoonlijke begeleiding. Bekijk het actuele lesrooster of vraag een gratis proefles aan.',
        ],
        'pijnacker' => [
            'title' => 'Buiten sporten in Pijnacker',
            'description' => 'Bootcamp op vrijdag 18:30–19:30 en zondag 08:30–09:30 uur achter de Daltonschool in Ackerswoude, Pijnacker. Vraag een gratis proefles aan.',
        ],
    ],

];
