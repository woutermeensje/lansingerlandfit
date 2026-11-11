<?php

namespace App\Support;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

/**
 * Leest het weekrooster uit config/site.php.
 */
class Schedule
{
    public static function lessons(): Collection
    {
        return collect(config('site.schedule'))
            ->sortBy(fn (array $l) => sprintf('%d-%s', $l['day'], $l['from']))
            ->values();
    }

    public static function find(string $id): ?array
    {
        return self::lessons()->firstWhere('id', $id);
    }

    /** Lessen per dag (1-7), inclusief lege dagen. */
    public static function byDay(): Collection
    {
        $lessons = self::lessons();

        return collect(config('site.days'))->map(fn (string $label, int $day) => [
            'label' => $label,
            'lessons' => $lessons->where('day', $day)->values(),
        ]);
    }

    public static function forTraining(string $slug): Collection
    {
        return self::lessons()->where('training', $slug)->values();
    }

    /** De eerstvolgende datums waarop een les plaatsvindt. */
    public static function upcomingDates(array $lesson, int $count = 6): Collection
    {
        $date = CarbonImmutable::today();
        $now = CarbonImmutable::now();

        $dates = collect();
        while ($dates->count() < $count) {
            if ($date->dayOfWeekIso === $lesson['day']
                && $date->setTimeFromTimeString($lesson['from'])->greaterThan($now)) {
                $dates->push($date);
            }
            $date = $date->addDay();
        }

        return $dates;
    }
}
