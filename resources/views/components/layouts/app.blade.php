@props([
    'title' => null,
    'description' => 'Buitensporten, groepslessen, personal training en zwangerschapstraining in Lansingerland, Pijnacker en Nootdorp. Plan een gratis proefles.',
])

@php($fullTitle = $title ? $title.' | '.config('site.name') : 'Personal training | Bootcamp | Lansingerland | Pijnacker | Nootdorp')

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $fullTitle }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $fullTitle }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/personal-training.png') }}">
    <meta property="og:locale" content="nl_NL">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700|work-sans:700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'SportsActivityLocation',
            'name' => config('site.name'),
            'url' => url('/'),
            'telephone' => config('site.contact.phone'),
            'email' => config('site.contact.email'),
            'areaServed' => config('site.regions'),
            'founder' => ['@type' => 'Person', 'name' => config('site.contact.person')],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
</head>
<body class="flex min-h-screen flex-col">
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-white focus:px-4 focus:py-2">Naar inhoud</a>

    <x-navigation />

    <main id="main" class="flex-1">
        @if (session('status'))
            <div class="container-site pt-6">
                <div role="status" class="rounded-2xl bg-mint-100 px-5 py-4 text-sm font-medium text-mint-600 ring-1 ring-mint-400/50">
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
