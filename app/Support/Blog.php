<?php

namespace App\Support;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Blogs zijn Markdown-bestanden in resources/blogs met een simpele header:
 *
 *   ---
 *   title: Titel
 *   date: 2026-11-01
 *   excerpt: Korte samenvatting
 *   ---
 */
class Blog
{
    public static function all(): Collection
    {
        $dir = resource_path('blogs');

        if (! File::isDirectory($dir)) {
            return collect();
        }

        return collect(File::files($dir))
            ->filter(fn ($file) => $file->getExtension() === 'md')
            ->map(fn ($file) => self::parse($file->getFilenameWithoutExtension(), $file->getContents()))
            ->sortByDesc('date')
            ->values();
    }

    public static function find(string $slug): ?object
    {
        return self::all()->firstWhere('slug', $slug);
    }

    private static function parse(string $slug, string $contents): object
    {
        $meta = [];
        if (preg_match('/^---\R(.*?)\R---\R(.*)$/s', $contents, $m)) {
            foreach (preg_split('/\R/', $m[1]) as $line) {
                [$key, $value] = array_pad(explode(':', $line, 2), 2, '');
                $meta[trim($key)] = trim($value);
            }
            $contents = $m[2];
        }

        return (object) [
            'slug' => $slug,
            'title' => $meta['title'] ?? Str::headline($slug),
            'date' => CarbonImmutable::parse($meta['date'] ?? 'today'),
            'excerpt' => $meta['excerpt'] ?? Str::limit(strip_tags(Str::markdown($contents)), 160),
            'html' => Str::markdown($contents, ['html_input' => 'strip']),
        ];
    }
}
