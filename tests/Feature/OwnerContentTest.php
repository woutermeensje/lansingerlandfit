<?php

namespace Tests\Feature;

use App\Mail\NewContactRequest;
use App\Models\Price;
use App\Models\Training;
use App\Support\Schedule;
use App\Support\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OwnerContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_xco_walking_only_has_the_confirmed_wednesday_lesson(): void
    {
        $lessons = Schedule::forTraining('xco-walking');

        $this->assertCount(1, $lessons);
        $this->assertSame(3, $lessons->first()['day']);
        $this->assertSame('18:30', $lessons->first()['from']);
        $this->assertSame('19:30', $lessons->first()['to']);
        $this->assertNotNull(Schedule::forTraining('bootcamp-outdoor')->firstWhere('day', 5));

        $this->get('/xco-walking')->assertOk()->assertSee('Woensdag · 18:30 – 19:30');
        $this->get('/nootdorp')->assertOk()->assertViewHas('lessons', fn (Collection $lessons): bool => ! $lessons->contains('training', 'xco-walking'));
    }

    public function test_pregnancy_training_describes_individual_guidance(): void
    {
        $this->get('/zwangerschapsfitness')->assertOk()
            ->assertSee('Persoonlijke één-op-één begeleiding')
            ->assertDontSee('Trainen in kleine groepen')
            ->assertDontSee('Voorbereiding op de bevalling');
    }

    public function test_trial_request_keeps_the_chosen_training(): void
    {
        Mail::fake();

        $trialUrl = route('proefles', ['interesse' => 'Zwangerschapsfitness']);

        $this->get('/zwangerschapsfitness')->assertOk()->assertSee('href="'.$trialUrl.'"', false);
        $this->get($trialUrl)->assertOk()->assertSee('value="Zwangerschapsfitness" selected', false);

        $this->from($trialUrl)->post(route('contact.store'), [
            'first_name' => 'Anna',
            'last_name' => 'de Vries',
            'email' => 'anna@example.com',
            'source' => 'proefles',
            'interest' => 'Zwangerschapsfitness',
        ])->assertRedirect($trialUrl)->assertSessionHasNoErrors()->assertSessionHas('status');

        $this->assertDatabaseHas('contact_requests', [
            'email' => 'anna@example.com',
            'source' => 'proefles',
            'interest' => 'Zwangerschapsfitness',
        ]);
        Mail::assertSent(NewContactRequest::class);
    }

    public function test_sportschools_and_dance_schools_can_request_information(): void
    {
        Mail::fake();

        foreach (['Groepslesinstructeur', 'Danspartner salsa en bachata'] as $interest) {
            $this->get(route('contact', ['interesse' => $interest]))->assertOk()
                ->assertSee('value="'.$interest.'" selected', false);

            $this->from('/contact')->post(route('contact.store'), [
                'first_name' => 'Test',
                'last_name' => 'Aanvraag',
                'email' => 'school@example.com',
                'interest' => $interest,
            ])->assertRedirect('/contact')->assertSessionHasNoErrors();

            $this->assertDatabaseHas('contact_requests', ['interest' => $interest, 'source' => 'contact']);
        }

        Mail::assertSent(NewContactRequest::class, 2);
    }

    public function test_missing_prices_are_visible_and_can_still_be_edited(): void
    {
        $this->get('/tarieven')->assertOk()
            ->assertSee('Zwangerschapsfitness')->assertSee('€ 49,-')
            ->assertSee('Seniorensport')->assertSee('€ 15,-')->assertSee('10-rittenkaart € 140,-')
            ->assertSee('Duo Training')->assertSee('Op aanvraag');

        Price::where('title', 'Zwangerschapsfitness')->firstOrFail()->update(['price' => '€ 52,-']);

        $this->get('/tarieven')->assertOk()->assertSee('€ 52,-')->assertDontSee('€ 49,-');
    }

    public function test_removed_services_redirect_and_are_absent_from_public_pages(): void
    {
        foreach (['/afval-begeleiding', '/voedings-advies'] as $path) {
            $this->get($path)->assertStatus(301)->assertRedirect('/trainingen');
        }

        foreach (['/', '/trainingen', '/contact', '/gratis-proefles', '/caloriebehoefte-calculator', '/sitemap', '/sitemap.xml'] as $path) {
            $this->get($path)->assertOk()
                ->assertDontSee('Afvalbegeleiding')->assertDontSee('Voedingsadvies')
                ->assertDontSee('/afval-begeleiding')->assertDontSee('/voedings-advies');
        }
    }

    public function test_removed_services_cannot_be_requested_from_the_contact_form(): void
    {
        Mail::fake();

        foreach (['Afvalbegeleiding', 'Voedingsadvies'] as $interest) {
            $this->from('/contact')->post(route('contact.store'), [
                'first_name' => 'Anna',
                'last_name' => 'de Vries',
                'email' => 'anna@example.com',
                'interest' => $interest,
            ])->assertRedirect('/contact')->assertSessionHasErrors('interest');
        }

        $this->assertDatabaseCount('contact_requests', 0);
        Mail::assertNothingSent();
    }

    public function test_owner_update_preserves_admin_edits_and_does_not_duplicate_prices(): void
    {
        $training = Training::where('slug', 'zwangerschapsfitness')->firstOrFail();
        $training->update([
            'intro' => 'Trainen in kleine groepen in de buitenlucht, speciaal voor zwangere vrouwen. Veilig, verantwoord en als voorbereiding op de bevalling.',
            'body' => ['Mijn eigen tekst uit de beheeromgeving.'],
        ]);
        Price::where('title', 'Seniorensport')->firstOrFail()->update(['price' => '€ 22,-']);
        $priceCount = Price::count();

        $migration = require database_path('migrations/2026_11_17_114617_align_content_with_owner_input.php');
        $migration->up();
        Site::flush();

        $this->assertStringContainsString('één-op-één begeleiding', $training->fresh()->intro);
        $this->assertSame(['Mijn eigen tekst uit de beheeromgeving.'], $training->fresh()->body);
        $this->assertSame($priceCount, Price::count());
        $this->assertDatabaseHas('prices', ['title' => 'Seniorensport', 'price' => '€ 22,-']);
    }
}
