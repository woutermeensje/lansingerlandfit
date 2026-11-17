<?php

return [
    'required' => 'Vul je :attribute in.',
    'email' => 'Vul een geldig e-mailadres in.',
    'string' => ':Attribute moet tekst zijn.',
    'integer' => ':Attribute moet een heel getal zijn.',
    'boolean' => ':Attribute moet aan of uit staan.',
    'max' => [
        'string' => ':Attribute mag maximaal :max tekens bevatten.',
        'numeric' => ':Attribute mag maximaal :max zijn.',
        'file' => ':Attribute mag maximaal :max kB groot zijn.',
    ],
    'min' => [
        'string' => ':Attribute moet minimaal :min tekens bevatten.',
        'numeric' => ':Attribute moet minimaal :min zijn.',
    ],
    'between' => ['numeric' => ':Attribute moet tussen :min en :max liggen.'],
    'in' => 'Kies een geldige optie voor :attribute.',
    'not_in' => 'Deze :attribute is niet beschikbaar.',
    'exists' => 'Kies een geldige optie voor :attribute.',
    'unique' => 'Deze :attribute is al in gebruik.',
    'confirmed' => 'De twee wachtwoorden zijn niet gelijk.',
    'current_password' => 'Je huidige wachtwoord klopt niet.',
    'date_format' => 'Kies een geldige :attribute.',
    'after' => ':Attribute moet na :date liggen.',
    'regex' => ':Attribute heeft een ongeldig formaat.',
    'image' => ':Attribute moet een afbeelding zijn.',
    'mimes' => ':Attribute moet een bestand zijn van het type: :values.',
    'uploaded' => ':Attribute kon niet worden geüpload. Probeer een kleiner bestand.',
    'attributes' => [],
];
