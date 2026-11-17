<?php

namespace App\Support;

/**
 * Wie een notificatie krijgt bij een nieuwe aanvraag (contactformulier of reservering):
 * het admin-adres (ADMIN_EMAIL) én het contactadres (CONTACT_EMAIL).
 * Is het hetzelfde adres, dan komt de mail maar één keer binnen.
 */
class Notify
{
    /** @return list<string> */
    public static function recipients(): array
    {
        return collect([config('site.contact.notify'), config('site.contact.cc')])
            ->filter(fn ($email) => filled($email))
            ->map(fn ($email) => trim($email))
            ->unique(fn ($email) => strtolower($email))
            ->values()
            ->all();
    }
}
