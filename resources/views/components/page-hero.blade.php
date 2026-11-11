@props(['eyebrow' => null, 'title', 'intro' => null])

<section class="relative overflow-hidden bg-gradient-to-b from-mint-100/70 to-cream">
    <div class="container-site py-14 sm:py-20">
        @if ($eyebrow)
            <p class="eyebrow">{{ $eyebrow }}</p>
        @endif
        <h1 class="mt-3 max-w-3xl text-4xl sm:text-5xl">{{ $title }}</h1>
        @if ($intro)
            <p class="mt-5 max-w-2xl text-lg leading-relaxed text-gray-600">{{ $intro }}</p>
        @endif
        {{ $slot }}
    </div>
</section>
