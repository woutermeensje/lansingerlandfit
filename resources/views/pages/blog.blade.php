<x-layouts.app :title="$post->title" :description="$post->excerpt">
    <article class="container-site max-w-3xl py-14">
        <a href="{{ route('blogs') }}" class="text-sm text-gray-500 hover:text-mint-600">&larr; Alle blogs</a>
        <time datetime="{{ $post->date->toDateString() }}" class="mt-6 block text-sm text-gray-500">{{ $post->date->translatedFormat('j F Y') }}</time>
        <h1 class="mt-2 text-4xl sm:text-5xl">{{ $post->title }}</h1>
        <div class="prose-site mt-8 text-lg">{!! $post->html !!}</div>
    </article>
</x-layouts.app>
