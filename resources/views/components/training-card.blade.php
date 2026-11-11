@props(['slug', 'training', 'cta' => 'Meer informatie'])

<article class="card group flex flex-col overflow-hidden transition hover:-translate-y-1 hover:shadow-lg">
    <a href="{{ route('training', $slug) }}" class="block aspect-[4/3] overflow-hidden bg-mint-100" tabindex="-1" aria-hidden="true">
        @if ($image = $training['card_image'] ?? $training['image'])
            <img src="{{ asset($image) }}" alt="" loading="lazy" class="size-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <div class="flex size-full items-center justify-center">
                <svg class="size-16 text-mint-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
            </div>
        @endif
    </a>
    <div class="flex flex-1 flex-col p-6">
        <h3 class="text-xl"><a href="{{ route('training', $slug) }}">{{ $training['title'] }}</a></h3>
        <p class="mt-2 flex-1 text-sm leading-relaxed text-gray-600">{{ $training['short'] }}</p>
        <a href="{{ route('training', $slug) }}" class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-mint-600 hover:text-navy-700">
            {{ $cta }} <span aria-hidden="true">&rarr;</span>
        </a>
    </div>
</article>
