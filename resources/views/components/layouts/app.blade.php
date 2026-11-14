@props([
    // Optionele overrides; standaard komt alles uit config/seo.php via App\Support\Seo.
    'title' => null,
    'description' => null,
    // Vraag/antwoord-paren ([vraag, antwoord]) voor FAQPage structured data.
    'faqs' => [],
])

@php
    $seo = \App\Support\Seo::current();
    if ($title) $seo['title'] = \App\Support\Seo::title($title);
    if ($description) $seo['description'] = $description;
@endphp

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="robots" content="{{ $seo['robots'] }}">
    <link rel="canonical" href="{{ $seo['url'] }}">

    <meta property="og:type" content="{{ $seo['type'] }}">
    <meta property="og:site_name" content="{{ config('site.name') }}">
    <meta property="og:locale" content="nl_NL">
    <meta property="og:title" content="{{ $seo['title'] }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    <meta property="og:url" content="{{ $seo['url'] }}">
    <meta property="og:image" content="{{ $seo['image'] }}">
    <meta property="og:image:alt" content="{{ $seo['name'] }}">
    @isset($seo['published'])
        <meta property="article:published_time" content="{{ $seo['published'] }}">
        <meta property="article:modified_time" content="{{ $seo['lastmod'] }}">
    @endisset
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo['title'] }}">
    <meta name="twitter:description" content="{{ $seo['description'] }}">
    <meta name="twitter:image" content="{{ $seo['image'] }}">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=work-sans:400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script type="application/ld+json">
        {!! json_encode(\App\Support\Seo::schema($seo, $faqs), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
    </script>
</head>
<body class="flex min-h-screen flex-col">
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-base focus:bg-white focus:px-4 focus:py-2">Naar inhoud</a>

    <x-navigation />

    <main id="main" class="flex-1">
        @if (session('status'))
            <div class="container-site pt-6">
                <div role="status" class="rounded-base bg-mint-100 px-5 py-4 text-sm font-medium text-mint-600 border border-line">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    <x-cta-band />
    <x-site-footer />
</body>
</html>
