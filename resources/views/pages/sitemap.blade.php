<x-layouts.app>
    <x-page-hero eyebrow="Sitemap" title="Alle pagina's op een rij" intro="Een overzicht van alle trainingen, locaties, begeleiding, tools en blogs op Lansingerlandfit.nl." />

    <section class="container-site grid gap-10 py-12 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($groups as $group => $entries)
            <div>
                <h2 class="text-xl">{{ $group }}</h2>
                <ul class="mt-4 space-y-3">
                    @foreach ($entries as $entry)
                        <li>
                            <a href="{{ $entry['url'] }}" class="font-semibold text-navy-700 hover:text-mint-600">{{ $entry['name'] }}</a>
                            <p class="mt-1 text-sm leading-relaxed text-gray-600">{{ $entry['description'] }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </section>
</x-layouts.app>
