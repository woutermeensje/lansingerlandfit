@php
    $trainingItems = collect(config('site.trainings'))->flatMap(fn (array $t, string $slug) => array_filter([
        [
            'url' => route('training', $slug),
            'label' => $t['title'],
            'active' => request()->routeIs('training') && request()->route('training') === $slug,
        ],
        // Duo training heeft een eigen pagina en staat direct na Personal Training.
        $slug === 'personal-training' ? [
            'url' => route('duo-training'),
            'label' => 'Duo Training',
            'active' => request()->routeIs('duo-training'),
        ] : null,
    ]))->values()->all();

    $adviceItems = [
        ['url' => route('afval-begeleiding'), 'label' => 'Afvalbegeleiding', 'active' => request()->routeIs('afval-begeleiding')],
        ['url' => route('voedings-advies'), 'label' => 'Voedingsadvies', 'active' => request()->routeIs('voedings-advies')],
    ];

    $toolItems = [
        ['url' => route('caloriebehoefte-calculator'), 'label' => 'Caloriebehoefte calculator', 'active' => request()->routeIs('caloriebehoefte-calculator')],
    ];

    $links = [
        ['route' => 'lesrooster', 'label' => 'Lesrooster'],
        ['route' => 'tarieven', 'label' => 'Tarieven'],
        ['route' => 'trainingen', 'label' => 'Trainingen', 'children' => $trainingItems],
        // Advies en Tools hebben (nog) geen overzichtspagina: het hoofditem linkt naar het eerste subitem.
        ['route' => 'afval-begeleiding', 'label' => 'Advies', 'children' => $adviceItems],
        ['route' => 'caloriebehoefte-calculator', 'label' => 'Tools', 'children' => $toolItems],
        ['route' => 'blogs', 'label' => 'Blogs'],
        ['route' => 'over-ons', 'label' => 'Over ons'],
        ['route' => 'contact', 'label' => 'Contact'],
    ];
    $active = fn (array $link) => request()->routeIs($link['route'], $link['route'].'.*')
        || collect($link['children'] ?? [])->contains('active', true);
    $phone = config('site.contact.phone');
    $phoneHref = 'tel:'.preg_replace('/\D/', '', $phone);
@endphp

<header class="site-header">
    <div class="site-header__inner">
        <div class="site-header__brand">
            <x-logo />
        </div>

        <nav class="site-header__nav" aria-label="Hoofdmenu">
            <ul class="site-nav__list">
                @foreach ($links as $link)
                    <li @class(['site-nav__item', 'site-nav__item--has-children' => ! empty($link['children'])])>
                        <a href="{{ route($link['route']) }}" @class(['site-nav__link', 'is-active' => $active($link)])>
                            {{ $link['label'] }}
                            @if (! empty($link['children']))<span class="site-nav__chev" aria-hidden="true"></span>@endif
                        </a>
                        @if (! empty($link['children']))
                            <ul class="site-nav__dropdown">
                                @foreach ($link['children'] as $child)
                                    <li class="site-nav__item">
                                        <a href="{{ $child['url'] }}" @class(['site-nav__link', 'is-active' => $child['active']])>{{ $child['label'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="site-header__divider"></div>

        <div class="site-header__cta">
            <a href="{{ $phoneHref }}" class="site-header__phone">{{ $phone }}</a>
            <a href="{{ route('proefles') }}" class="btn btn-primary">Gratis proefles</a>
        </div>

        <button type="button" class="site-header__hamburger" aria-label="Menu openen" aria-expanded="false" aria-controls="mobile-menu" data-menu-toggle>
            <span class="site-hamburger__bar"></span>
            <span class="site-hamburger__bar"></span>
            <span class="site-hamburger__bar"></span>
        </button>
    </div>
</header>

<div id="mobile-menu" class="mobile-nav" aria-hidden="true">
    <div class="mobile-nav__panel">
        <button type="button" class="mobile-nav__close" aria-label="Menu sluiten" data-menu-close>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>

        <nav aria-label="Mobiel menu">
            <ul class="mobile-nav__list">
                @foreach ($links as $link)
                    <li @class(['is-active' => $active($link)])>
                        <a href="{{ route($link['route']) }}">{{ $link['label'] }}</a>
                        @if (! empty($link['children']))
                            <ul>
                                @foreach ($link['children'] as $child)
                                    <li @class(['is-active' => $child['active']])><a href="{{ $child['url'] }}">{{ $child['label'] }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="mobile-nav__divider"></div>

        <div class="mobile-nav__ctas">
            <a href="{{ $phoneHref }}" class="btn btn-outline">Bel {{ $phone }}</a>
            <a href="{{ route('proefles') }}" class="btn btn-primary">Gratis proefles</a>
        </div>
    </div>
</div>
