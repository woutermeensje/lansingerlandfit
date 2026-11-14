<x-layouts.app>
    <x-page-hero eyebrow="Blogs" title="Tips & verhalen" intro="Over buiten sporten, gezond leven en fit blijven." />

    <section class="container-site py-12">
        @if ($posts->isEmpty())
            <p class="text-gray-600">Er zijn nog geen blogs geplaatst.</p>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($posts as $post)
                    <a href="{{ route('blogs.show', $post->slug) }}" class="card group flex flex-col p-6">
                        <time datetime="{{ $post->date->toDateString() }}" class="text-xs text-gray-500">{{ $post->date->translatedFormat('j F Y') }}</time>
                        <h2 class="mt-2 text-xl group-hover:text-mint-600">{{ $post->title }}</h2>
                        <p class="mt-3 flex-1 text-sm text-gray-600">{{ $post->excerpt }}</p>
                        <span class="mt-4 text-sm font-semibold text-mint-600">Lees verder &rarr;</span>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
</x-layouts.app>
