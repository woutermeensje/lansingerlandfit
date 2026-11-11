@php
    $trainings = config('site.trainings');
    $links = [
        ['route' => 'lesrooster', 'label' => 'Lesrooster'],
        ['route' => 'tarieven', 'label' => 'Tarieven'],
        ['route' => 'trainingen', 'label' => 'Trainingen', 'children' => true],
        ['route' => 'blogs', 'label' => 'Blogs'],
        ['route' => 'over-ons', 'label' => 'Over ons'],
        ['route' => 'contact', 'label' => 'Contact'],
    ];
    $active = fn (string $r) => request()->routeIs($r, $r.'.*') || ($r === 'trainingen' && request()->routeIs('training'));
@endphp

<header class="sticky top-0 z-40 border-b border-navy-100/60 bg-cream/90 backdrop-blur">
    <div class="container-site flex h-20 items-center justify-between gap-6">
        <x-logo />

        <nav class="hidden items-center gap-1 lg:flex" aria-label="Hoofdmenu">
            @foreach ($links as $link)
                @if ($link['children'] ?? false)
                    <div class="group relative">
                        <a href="{{ route($link['route']) }}" @class(['flex items-center gap-1 rounded-full px-4 py-2 text-sm font-medium transition hover:text-mint-600', 'text-mint-600' => $active($link['route']), 'text-navy-700' => ! $active($link['route'])])>
                            {{ $link['label'] }}
                            <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.06l3.71-3.83a.75.75 0 111.08 1.04l-4.25 4.39a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                        </a>
                        <div class="invisible absolute left-0 top-full w-64 pt-2 opacity-0 transition group-hover:visible group-hover:opacity-100 group-focus-within:visible group-focus-within:opacity-100">
                            <div class="card p-2">
                                @foreach ($trainings as $slug => $training)
                                    <a href="{{ route('training', $slug) }}" class="block rounded-xl px-4 py-2.5 text-sm text-navy-700 hover:bg-mint-100">{{ $training['title'] }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route($link['route']) }}" @class(['rounded-full px-4 py-2 text-sm font-medium transition hover:text-mint-600', 'text-mint-600' => $active($link['route']), 'text-navy-700' => ! $active($link['route'])])>{{ $link['label'] }}</a>
                @endif
            @endforeach
        </nav>

        <div class="hidden items-center gap-3 lg:flex">
            <a href="{{ route('contact') }}" class="btn btn-outline !py-2.5">Contact</a>
            <a href="{{ route('proefles') }}" class="btn btn-primary !py-2.5">Proefles</a>
        </div>

        <button type="button" class="rounded-xl p-2 text-navy-700 lg:hidden" data-menu-toggle aria-controls="mobile-menu" aria-expanded="false">
            <span class="sr-only">Menu</span>
            <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>
    </div>

    <nav id="mobile-menu" class="hidden border-t border-navy-100/60 bg-cream lg:hidden" aria-label="Mobiel menu">
        <div class="container-site space-y-1 py-4">
            @foreach ($links as $link)
                <a href="{{ route($link['route']) }}" class="block rounded-xl px-3 py-2.5 font-medium text-navy-700 hover:bg-mint-100">{{ $link['label'] }}</a>
                @if ($link['children'] ?? false)
                    <div class="ml-4 border-l border-navy-100 pl-3">
                        @foreach ($trainings as $slug => $training)
                            <a href="{{ route('training', $slug) }}" class="block rounded-xl px-3 py-2 text-sm text-navy-500 hover:bg-mint-100">{{ $training['title'] }}</a>
                        @endforeach
                    </div>
                @endif
            @endforeach
            <div class="grid grid-cols-2 gap-3 pt-3">
                <a href="{{ route('contact') }}" class="btn btn-outline">Contact</a>
                <a href="{{ route('proefles') }}" class="btn btn-primary">Proefles</a>
            </div>
        </div>
    </nav>
</header>
