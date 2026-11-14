{!! '<'.'?xml version="1.0" encoding="UTF-8"?'.'>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
@foreach ($entries as $entry)
    <url>
        <loc>{{ $entry['url'] }}</loc>
        <lastmod>{{ $entry['lastmod'] }}</lastmod>
        <image:image>
            <image:loc>{{ $entry['image'] }}</image:loc>
        </image:image>
    </url>
@endforeach
</urlset>
