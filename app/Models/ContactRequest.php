<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'interest', 'message', 'source'];

    /**
     * Waar een aanvraag vandaan komt: de waarde van `source` in het formulier,
     * met de naam die in de beheeromgeving wordt getoond.
     * Nieuwe pagina met een formulier? Voeg de bron hier toe, anders wordt het formulier geweigerd.
     */
    public const SOURCES = [
        'contact' => 'Contactpagina',
        'proefles' => 'Gratis proefles',
        'duo-training' => 'Duo training',
        'afval-begeleiding' => 'Afvalbegeleiding',
        'voedings-advies' => 'Voedingsadvies',
        'over-ons' => 'Over ons',
    ];

    public function sourceLabel(): string
    {
        return self::SOURCES[$this->source] ?? ucfirst($this->source);
    }

    public function fullName(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }
}
