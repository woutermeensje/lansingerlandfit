<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Bouwt de SEO-gegevens (titel, beschrijving, canonical, afbeelding,
 * broodkruimels, structured data) per pagina op uit config/seo.php.
 */
class Seo
{
    /** SEO-gegevens van de huidige request. */
    public static function current(): array
    {
        $route = request()->route();

        return self::for($route?->getName(), $route?->parameters() ?? [])
            ?? [...self::page('home'), 'url' => self::url(request()->path()), 'breadcrumbs' => [], 'robots' => 'noindex, follow'];
    }

    public static function for(?string $name, array $params = []): ?array
    {
        return match ($name) {
            null => null,
            'training' => self::training((string) ($params['training'] ?? '')),
            'locatie' => self::location((string) ($params['location'] ?? '')),
            'blogs.show' => self::post((string) ($params['slug'] ?? '')),
            default => self::page($name),
        };
    }

    /** Alle indexeerbare pagina's, voor sitemap.xml en de HTML-sitemap. */
    public static function entries(): Collection
    {
        return collect(array_keys(config('seo.pages')))->map(fn ($name) => self::page($name))
            ->concat(collect(array_keys(config('site.trainings')))->map(fn ($slug) => self::training($slug)))
            ->concat(collect(array_keys(config('site.locations')))->map(fn ($slug) => self::location($slug)))
            ->concat(Blog::all()->map(fn ($post) => self::post($post->slug)))
            ->filter()
            ->values();
    }

    public static function page(string $name): ?array
    {
        $meta = config("seo.pages.$name");

        if (! $meta) {
            return null;
        }

        $path = route($name, absolute: false);

        return self::make($meta, $path, $name === 'home' ? [] : [[$meta['name'], $path]]);
    }

    public static function training(string $slug): ?array
    {
        $training = config("site.trainings.$slug");

        if (! $training) {
            return null;
        }

        $meta = config("seo.trainings.$slug", []);
        $path = route('training', $slug, false);

        return self::make([
            'name' => $training['title'],
            'group' => 'Trainingen',
            'title' => $meta['title'] ?? $training['title'],
            'description' => $meta['description'] ?? $training['intro'],
            'image' => $training['image'] ?? null,
            ...$meta,
        ], $path, [['Trainingen', route('trainingen', absolute: false)], [$training['title'], $path]]);
    }

    public static function location(string $slug): ?array
    {
        $location = config("site.locations.$slug");

        if (! $location) {
            return null;
        }

        $meta = config("seo.locations.$slug", []);
        $path = route('locatie', $slug, false);
        $name = 'Buiten sporten in '.$location['title'];

        return self::make([
            'name' => $name,
            'group' => 'Locaties',
            'title' => $meta['title'] ?? $name,
            'description' => $meta['description'] ?? $location['intro'],
            'image' => $location['image'] ?? null,
            ...$meta,
        ], $path, [[$name, $path]]);
    }

    public static function post(string $slug): ?array
    {
        $post = Blog::find($slug);

        if (! $post) {
            return null;
        }

        $path = route('blogs.show', $slug, false);

        return [
            ...self::make([
                'name' => $post->title,
                'group' => 'Blogs',
                'title' => $post->title,
                'description' => $post->excerpt,
                'updated' => $post->date->toDateString(),
            ], $path, [['Blogs', route('blogs', absolute: false)], [$post->title, $path]]),
            'type' => 'article',
            'published' => $post->date->toDateString(),
        ];
    }

    /** SEO-titel, met merknaam erachter zolang die binnen de maximale lengte past. */
    public static function title(string $title, bool $brand = true): string
    {
        $full = $title.config('seo.separator').config('seo.brand');

        return $brand && mb_strlen($full) <= config('seo.max_title') ? $full : $title;
    }

    /** Absolute URL op basis van APP_URL, zodat canonical en sitemap altijd hetzelfde domein gebruiken. */
    public static function url(string $path = '/'): string
    {
        return rtrim(config('app.url'), '/').'/'.ltrim($path, '/');
    }

    public static function robots(): string
    {
        return config('seo.indexable') ? 'index, follow, max-image-preview:large' : 'noindex, nofollow';
    }

    /** JSON-LD (schema.org) voor de pagina. */
    public static function schema(array $seo, array $faqs = []): array
    {
        $home = self::url('/');

        $graph = [
            [
                '@type' => 'SportsActivityLocation',
                '@id' => $home.'#business',
                'name' => config('site.name'),
                'description' => config('site.tagline'),
                'url' => $home,
                'image' => self::url(config('seo.default_image')),
                'logo' => self::url('favicon.svg'),
                'telephone' => config('site.contact.phone'),
                'email' => config('site.contact.email'),
                'areaServed' => collect(config('site.regions'))->map(fn ($r) => ['@type' => 'City', 'name' => $r])->all(),
                'founder' => ['@type' => 'Person', 'name' => config('site.contact.person')],
            ],
            [
                '@type' => 'WebSite',
                '@id' => $home.'#website',
                'name' => config('site.name'),
                'url' => $home,
                'inLanguage' => 'nl-NL',
                'publisher' => ['@id' => $home.'#business'],
            ],
            [
                '@type' => 'WebPage',
                '@id' => $seo['url'].'#webpage',
                'url' => $seo['url'],
                'name' => $seo['title'],
                'description' => $seo['description'],
                'inLanguage' => 'nl-NL',
                'isPartOf' => ['@id' => $home.'#website'],
                'primaryImageOfPage' => ['@type' => 'ImageObject', 'url' => $seo['image']],
                'dateModified' => $seo['lastmod'],
            ],
        ];

        if (count($seo['breadcrumbs']) > 1) {
            $graph[] = [
                '@type' => 'BreadcrumbList',
                'itemListElement' => collect($seo['breadcrumbs'])->values()->map(fn ($crumb, $i) => [
                    '@type' => 'ListItem',
                    'position' => $i + 1,
                    'name' => $crumb[0],
                    'item' => $crumb[1],
                ])->all(),
            ];
        }

        if (($seo['type'] ?? null) === 'article') {
            $graph[] = [
                '@type' => 'BlogPosting',
                'headline' => $seo['name'],
                'description' => $seo['description'],
                'image' => $seo['image'],
                'datePublished' => $seo['published'],
                'dateModified' => $seo['lastmod'],
                'inLanguage' => 'nl-NL',
                'mainEntityOfPage' => ['@id' => $seo['url'].'#webpage'],
                'author' => ['@type' => 'Person', 'name' => config('site.contact.person')],
                'publisher' => ['@id' => $home.'#business'],
            ];
        }

        if ($faqs) {
            $graph[] = [
                '@type' => 'FAQPage',
                'mainEntity' => collect($faqs)->map(fn ($faq) => [
                    '@type' => 'Question',
                    'name' => $faq[0],
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq[1]],
                ])->all(),
            ];
        }

        return ['@context' => 'https://schema.org', '@graph' => $graph];
    }

    private static function make(array $meta, string $path, array $trail): array
    {
        return [
            'name' => $meta['name'],
            'group' => $meta['group'] ?? 'Algemeen',
            'title' => self::title($meta['title'], $meta['brand'] ?? true),
            'description' => Str::limit($meta['description'], 160),
            'url' => self::url($path),
            'image' => self::url($meta['image'] ?? config('seo.default_image')),
            'type' => 'website',
            'lastmod' => $meta['updated'] ?? config('seo.updated'),
            'robots' => self::robots(),
            'breadcrumbs' => collect([['Home', '/'], ...$trail])
                ->map(fn ($crumb) => [$crumb[0], self::url($crumb[1])])
                ->all(),
        ];
    }
}
