<?php

namespace App\Support;

use App\Models\Lesson;
use App\Models\Price;
use App\Models\Training;
use Illuminate\Support\Collection;

/**
 * Bewerkbare inhoud uit de database (trainingen, lesrooster, tarieven),
 * in dezelfde vorm als toen het nog in config/site.php stond.
 * Per request wordt elke tabel maar één keer opgehaald.
 */
class Site
{
    private static array $memo = [];

    /** @return array<string, array> trainingen op slug */
    public static function trainings(): array
    {
        return self::$memo['trainings'] ??= Training::query()
            ->orderBy('sort_order')->orderBy('title')->get()
            ->mapWithKeys(fn (Training $t) => [$t->slug => $t->toContent()])
            ->all();
    }

    public static function training(string $slug): ?array
    {
        return self::trainings()[$slug] ?? null;
    }

    public static function lessons(): Collection
    {
        return self::$memo['lessons'] ??= Lesson::with('training')->get()
            ->map(fn (Lesson $l) => $l->toContent());
    }

    public static function prices(): array
    {
        return self::$memo['prices'] ??= Price::query()
            ->orderBy('sort_order')->orderBy('id')->get()
            ->map(fn (Price $p) => $p->toContent())
            ->all();
    }

    /** Keuzes voor "Waar heb je interesse in?": de vaste lijst plus die van nieuwe trainingen. */
    public static function interests(): array
    {
        $fixed = config('site.interests');
        $other = array_pop($fixed); // "Anders, namelijk" blijft onderaan.

        $extra = collect(self::trainings())->pluck('interest')
            ->reject(fn ($i) => collect($fixed)->contains(fn ($f) => strcasecmp($f, $i) === 0));

        return [...$fixed, ...$extra->values(), $other];
    }

    public static function flush(): void
    {
        self::$memo = [];
    }
}
