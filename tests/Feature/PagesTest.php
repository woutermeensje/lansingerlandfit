<?php

namespace Tests\Feature;

use App\Support\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_static_pages_render(): void
    {
        foreach (['/', '/lesrooster', '/tarieven', '/trainingen', '/over-ons', '/contact', '/gratis-proefles', '/duo-training', '/caloriebehoefte-calculator', '/sportparken-lansingerland', '/blogs', '/blogs/waarom-buiten-sporten'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_training_and_location_pages_render(): void
    {
        $this->assertCount(6, Site::trainings());

        foreach (Site::trainings() as $slug => $training) {
            $this->get("/$slug")->assertOk()->assertSee($training['title']);
        }

        foreach (array_keys(config('site.locations')) as $slug) {
            $this->get("/$slug")->assertOk();
        }
    }

    public function test_unknown_page_is_404(): void
    {
        $this->get('/bestaat-niet')->assertNotFound();
    }

    public function test_old_wordpress_links_redirect(): void
    {
        $this->get('/zwangerschapstraining')->assertRedirect('/zwangerschapsfitness');
        $this->get('/lidmaatschap')->assertRedirect('/tarieven');
    }

    public function test_sitemap(): void
    {
        $this->get('/sitemap.xml')->assertOk()->assertSee(url('/xco-walking'), false);
    }
}
