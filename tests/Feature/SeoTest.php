<?php

namespace Tests\Feature;

use App\Support\Seo;
use Tests\TestCase;

class SeoTest extends TestCase
{
    public function test_every_page_has_unique_seo_title_and_description(): void
    {
        $entries = Seo::entries();

        $this->assertGreaterThan(20, $entries->count());

        foreach ($entries as $entry) {
            $this->assertLessThanOrEqual(60, mb_strlen($entry['title']), "SEO-titel te lang: {$entry['url']}");
            $this->assertGreaterThanOrEqual(70, mb_strlen($entry['description']), "Metabeschrijving te kort: {$entry['url']}");
            $this->assertLessThanOrEqual(160, mb_strlen($entry['description']), "Metabeschrijving te lang: {$entry['url']}");
        }

        $this->assertSame($entries->count(), $entries->pluck('title')->unique()->count(), 'SEO-titels zijn niet uniek');
        $this->assertSame($entries->count(), $entries->pluck('description')->unique()->count(), 'Metabeschrijvingen zijn niet uniek');
    }

    public function test_pages_render_their_seo_tags(): void
    {
        foreach (Seo::entries() as $entry) {
            $path = parse_url($entry['url'], PHP_URL_PATH) ?: '/';

            $this->get($path)
                ->assertOk()
                ->assertSee('<title>'.e($entry['title']).'</title>', false)
                ->assertSee('<meta name="description" content="'.e($entry['description']).'">', false)
                ->assertSee('<link rel="canonical" href="'.$entry['url'].'">', false)
                ->assertSee('application/ld+json', false);
        }
    }

    public function test_sitemap_lists_every_page(): void
    {
        $response = $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        foreach (Seo::entries() as $entry) {
            $response->assertSee('<loc>'.$entry['url'].'</loc>', false);
        }

        $this->assertNotFalse(simplexml_load_string($response->getContent()), 'sitemap.xml is geen geldige XML');
    }

    public function test_html_sitemap(): void
    {
        $this->get('/sitemap')->assertOk()->assertSee('Xco Walking')->assertSee('Buiten sporten in Nootdorp');
    }

    public function test_robots_txt_points_to_sitemap(): void
    {
        $this->get('/robots.txt')->assertOk()->assertSee('Sitemap: '.Seo::url('sitemap.xml'), false);
    }

    public function test_indexing_follows_config(): void
    {
        config(['seo.indexable' => false]);
        $this->get('/')->assertSee('content="noindex, nofollow"', false);
        $this->get('/robots.txt')->assertSee('Disallow: /');

        config(['seo.indexable' => true]);
        $this->get('/')->assertSee('content="index, follow, max-image-preview:large"', false);
        $this->get('/robots.txt')->assertSee('Allow: /');
    }

    public function test_faq_pages_have_faq_schema(): void
    {
        $this->get('/duo-training')->assertSee('"@type":"FAQPage"', false);
    }
}
