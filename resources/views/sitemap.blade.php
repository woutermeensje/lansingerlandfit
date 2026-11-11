{!! '<'.'?xml version="1.0" encoding="UTF-8"?'.'>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach (['home', 'lesrooster', 'tarieven', 'trainingen', 'blogs', 'over-ons', 'contact', 'proefles'] as $name)
    <url><loc>{{ route($name) }}</loc></url>
@endforeach
@foreach (array_keys(config('site.trainings')) as $slug)
    <url><loc>{{ route('training', $slug) }}</loc></url>
@endforeach
@foreach (array_keys(config('site.locations')) as $slug)
    <url><loc>{{ route('locatie', $slug) }}</loc></url>
@endforeach
@foreach (\App\Support\Blog::all() as $post)
    <url><loc>{{ route('blogs.show', $post->slug) }}</loc><lastmod>{{ $post->date->toDateString() }}</lastmod></url>
@endforeach
</urlset>
