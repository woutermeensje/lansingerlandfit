@props(['title', 'guest' => false])

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title }} · Beheer {{ config('site.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=work-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin">
    <header class="admin-bar">
        <div class="admin-bar__inner">
            <a href="{{ $guest ? route('home') : route('admin.dashboard') }}" class="admin-bar__brand">
                <span class="text-lg font-extrabold leading-none text-navy-700">Lansingerland<span class="text-mint-500">fit</span><span class="text-sm font-bold text-navy-500">.nl</span></span>
                <span class="admin-bar__badge">Beheer</span>
            </a>

            @auth
                <nav class="admin-nav" aria-label="Beheer">
                    @foreach ([
                        'admin.dashboard' => 'Dashboard',
                        'admin.lessons.*' => 'Lesrooster',
                        'admin.trainings.*' => 'Trainingen',
                        'admin.prices.*' => 'Tarieven',
                        'admin.users.*' => 'Beheerders',
                    ] as $route => $label)
                        <a href="{{ route(str_replace('.*', '.index', $route)) }}" @class(['admin-nav__link', 'is-active' => request()->routeIs($route)])>{{ $label }}</a>
                    @endforeach
                </nav>

                <div class="admin-bar__actions">
                    <a href="{{ route('home') }}" class="admin-nav__link admin-bar__site" target="_blank" rel="noopener">Bekijk site</a>
                    <a href="{{ route('admin.account') }}" @class(['admin-nav__link', 'is-active' => request()->routeIs('admin.account')])>{{ auth()->user()->name }}</a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-quiet">Uitloggen</button>
                    </form>
                </div>
            @endauth
        </div>
    </header>

    <main @class(['admin-shell', 'admin-shell--narrow' => $guest])>
        @if (session('status'))
            <div role="status" class="admin-alert admin-alert--success">{{ session('status') }}</div>
        @endif

        @if ($errors->has('user'))
            <div role="alert" class="admin-alert admin-alert--error">{{ $errors->first('user') }}</div>
        @endif

        {{ $slot }}
    </main>
</body>
</html>
