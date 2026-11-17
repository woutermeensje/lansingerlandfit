<?php

namespace Tests\Feature;

use App\Models\Lesson;
use App\Models\Price;
use App\Models\Training;
use App\Models\User;
use App\Notifications\AdminPasswordLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['name' => 'Cindy', 'email' => 'cindy@example.com', 'password' => 'geheim-wachtwoord']);
    }

    // ── Inloggen ──

    public function test_guests_are_sent_to_login(): void
    {
        foreach (['/admin', '/admin/lesrooster', '/admin/trainingen', '/admin/tarieven', '/admin/beheerders', '/admin/account'] as $url) {
            $this->get($url)->assertRedirect('/admin/inloggen');
        }
    }

    public function test_login_page_is_not_indexed(): void
    {
        $this->get('/admin/inloggen')->assertOk()->assertSee('noindex, nofollow', false);
    }

    public function test_admin_can_log_in_and_out(): void
    {
        $this->admin();

        $this->post('/admin/inloggen', ['email' => 'cindy@example.com', 'password' => 'geheim-wachtwoord'])
            ->assertRedirect('/admin');
        $this->assertAuthenticated();

        $this->get('/admin')->assertOk()->assertSee('Hoi Cindy');
        $this->get('/admin/inloggen')->assertRedirect('/admin');

        $this->post('/admin/uitloggen')->assertRedirect('/admin/inloggen');
        $this->assertGuest();
    }

    public function test_wrong_password_is_rejected_and_throttled(): void
    {
        $this->admin();

        for ($i = 0; $i < 5; $i++) {
            $this->post('/admin/inloggen', ['email' => 'cindy@example.com', 'password' => 'fout'])
                ->assertSessionHasErrors(['email' => 'Dit e-mailadres en wachtwoord horen niet bij elkaar.']);
        }

        // Ook met het goede wachtwoord geblokkeerd na 5 foute pogingen.
        $this->post('/admin/inloggen', ['email' => 'cindy@example.com', 'password' => 'geheim-wachtwoord'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    // ── Wachtwoord vergeten ──

    public function test_forgot_password_sends_dutch_link_and_reset_works(): void
    {
        Notification::fake();
        $user = $this->admin();

        $this->post('/admin/wachtwoord-vergeten', ['email' => 'cindy@example.com'])->assertSessionHas('status');

        $token = null;
        Notification::assertSentTo($user, AdminPasswordLink::class, function ($n) use (&$token, $user) {
            $token = $n->token;
            $mail = $n->toMail($user);

            return ! $n->invite && $mail->subject === 'Wachtwoord opnieuw instellen'
                && str_contains($mail->viewData['url'], '/admin/wachtwoord-instellen/');
        });

        $this->get("/admin/wachtwoord-instellen/$token?email=cindy@example.com")->assertOk()->assertSee('cindy@example.com');

        $this->post('/admin/wachtwoord-instellen', [
            'token' => $token,
            'email' => 'cindy@example.com',
            'password' => 'nieuw-wachtwoord-123',
            'password_confirmation' => 'nieuw-wachtwoord-123',
        ])->assertRedirect('/admin');

        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Hash::check('nieuw-wachtwoord-123', $user->fresh()->password));
    }

    public function test_forgot_password_does_not_reveal_unknown_emails(): void
    {
        Notification::fake();

        $this->post('/admin/wachtwoord-vergeten', ['email' => 'onbekend@example.com'])
            ->assertSessionHas('status')->assertSessionHasNoErrors();

        Notification::assertNothingSent();
    }

    public function test_reset_with_invalid_token_fails(): void
    {
        $this->admin();

        $this->post('/admin/wachtwoord-instellen', [
            'token' => 'onzin',
            'email' => 'cindy@example.com',
            'password' => 'nieuw-wachtwoord-123',
            'password_confirmation' => 'nieuw-wachtwoord-123',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    // ── Beheerders ──

    public function test_admin_can_invite_another_admin(): void
    {
        Notification::fake();
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/beheerders', ['name' => 'Wouter', 'email' => 'Wouter@Example.com'])
            ->assertRedirect('/admin/beheerders');

        $new = User::where('email', 'wouter@example.com')->firstOrFail();
        Notification::assertSentTo($new, AdminPasswordLink::class, fn ($n) => $n->invite
            && Password::broker()->tokenExists($new, $n->token));

        // Dubbel e-mailadres mag niet.
        $this->actingAs($admin)->post('/admin/beheerders', ['name' => 'X', 'email' => 'wouter@example.com'])
            ->assertSessionHasErrors('email');
    }

    public function test_admin_cannot_delete_themselves_but_can_delete_others(): void
    {
        $admin = $this->admin();
        $other = User::factory()->create();

        $this->actingAs($admin)->delete("/admin/beheerders/{$admin->id}")->assertSessionHasErrors('user');
        $this->assertModelExists($admin);

        $this->actingAs($admin)->delete("/admin/beheerders/{$other->id}")->assertRedirect('/admin/beheerders');
        $this->assertModelMissing($other);
    }

    public function test_change_own_password_requires_current_password(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->put('/admin/account/wachtwoord', [
            'current_password' => 'fout',
            'password' => 'nieuw-wachtwoord-123',
            'password_confirmation' => 'nieuw-wachtwoord-123',
        ])->assertSessionHasErrors('current_password');

        $this->actingAs($admin)->put('/admin/account/wachtwoord', [
            'current_password' => 'geheim-wachtwoord',
            'password' => 'nieuw-wachtwoord-123',
            'password_confirmation' => 'nieuw-wachtwoord-123',
        ])->assertSessionHasNoErrors();

        $this->assertTrue(Hash::check('nieuw-wachtwoord-123', $admin->fresh()->password));
    }

    // ── Alle pagina's openen ──

    public function test_all_admin_pages_render(): void
    {
        $admin = $this->admin();
        $lesson = Lesson::first();
        $training = Training::first();
        $price = Price::first();

        foreach ([
            '/admin', '/admin/lesrooster', '/admin/lesrooster/nieuw', "/admin/lesrooster/{$lesson->id}/bewerken",
            '/admin/trainingen', '/admin/trainingen/nieuw', "/admin/trainingen/{$training->id}/bewerken",
            '/admin/tarieven', '/admin/tarieven/nieuw', "/admin/tarieven/{$price->id}/bewerken",
            '/admin/beheerders', '/admin/beheerders/nieuw', '/admin/account',
        ] as $url) {
            $this->actingAs($admin)->get($url)->assertOk();
        }
    }

    // ── Lesrooster ──

    public function test_lesson_crud_shows_on_schedule(): void
    {
        $admin = $this->admin();
        $training = Training::where('slug', 'xco-walking')->first();

        $this->actingAs($admin)->post('/admin/lesrooster', [
            'training_id' => $training->id,
            'name' => '',
            'day' => 6,
            'starts_at' => '09:00',
            'ends_at' => '10:00',
            'location' => 'Dobbeplas, Nootdorp',
        ])->assertRedirect('/admin/lesrooster');

        $lesson = Lesson::where('day', 6)->firstOrFail();
        $this->assertSame('Xco Walking', $lesson->name, 'Lege naam wordt de naam van de training');

        $this->get('/lesrooster')->assertSee('Zaterdag')->assertSee('09:00 – 10:00');
        $this->get('/nootdorp')->assertSee('Zaterdag · 09:00 – 10:00');

        $this->actingAs($admin)->put("/admin/lesrooster/{$lesson->id}", [
            'training_id' => $training->id, 'name' => 'Xco Ochtend', 'day' => 6,
            'starts_at' => '11:15', 'ends_at' => '12:15', 'location' => 'Dobbeplas, Nootdorp',
        ])->assertRedirect('/admin/lesrooster');
        $this->get('/lesrooster')->assertSee('Xco Ochtend')->assertSee('11:15 – 12:15');

        $this->actingAs($admin)->followingRedirects()->delete("/admin/lesrooster/{$lesson->id}")->assertSee('is verwijderd');
        $this->get('/lesrooster')->assertDontSee('Xco Ochtend');
    }

    public function test_lesson_end_must_be_after_start(): void
    {
        $this->actingAs($this->admin())->post('/admin/lesrooster', [
            'training_id' => Training::first()->id, 'day' => 1,
            'starts_at' => '10:00', 'ends_at' => '09:00', 'location' => 'Pijnacker',
        ])->assertSessionHasErrors(['ends_at' => 'De eindtijd moet na de begintijd liggen.']);
    }

    // ── Trainingen ──

    public function test_new_training_gets_its_own_page(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/trainingen', [
            'title' => 'Hardlopen voor Beginners',
            'slug' => '',
            'short' => 'Rustig opbouwen naar 5 km.',
            'intro' => 'In tien weken van de bank naar 5 kilometer.',
            'body' => "Eerste alinea\nmet een regel erbij.\n\nTweede alinea.",
            'benefits' => "- Rustig opbouwen\n\nIn een groep\n",
            'sort_order' => 7,
            'image' => UploadedFile::fake()->image('loop.jpg', 1200, 900),
        ])->assertRedirect('/admin/trainingen');

        $training = Training::where('slug', 'hardlopen-voor-beginners')->firstOrFail();
        $this->assertSame(['Eerste alinea met een regel erbij.', 'Tweede alinea.'], $training->body);
        $this->assertSame(['Rustig opbouwen', 'In een groep'], $training->benefits);
        $this->assertStringStartsWith('storage/trainingen/', $training->image);
        Storage::disk('public')->assertExists(str_replace('storage/', '', $training->image));

        $this->get('/hardlopen-voor-beginners')->assertOk()->assertSee('Hardlopen voor Beginners')->assertSee('Tweede alinea.');
        $this->get('/trainingen')->assertSee('Hardlopen voor Beginners');
        $this->get('/')->assertSee('/hardlopen-voor-beginners', false); // menu/footer
        $this->get('/sitemap.xml')->assertSee(url('/hardlopen-voor-beginners'), false);
        $this->get('/contact')->assertSee('<option value="Hardlopen voor Beginners"', false);
    }

    public function test_training_url_cannot_clash_with_existing_pages(): void
    {
        $admin = $this->admin();
        $base = ['title' => 'X', 'short' => 'x', 'intro' => 'x', 'sort_order' => 1];

        foreach (['tarieven', 'lesrooster', 'admin', 'nootdorp', 'xco-walking', 'blogs'] as $slug) {
            $this->actingAs($admin)->post('/admin/trainingen', [...$base, 'slug' => $slug])->assertSessionHasErrors('slug');
        }
    }

    public function test_slug_cannot_be_changed_after_creation(): void
    {
        $admin = $this->admin();
        $training = Training::where('slug', 'xco-walking')->first();

        $this->actingAs($admin)->put("/admin/trainingen/{$training->id}", [
            'slug' => 'iets-anders', 'title' => 'XCO Walking Nieuw', 'short' => 'x', 'intro' => 'x', 'body' => 'x', 'benefits' => 'x', 'sort_order' => 2,
        ])->assertRedirect('/admin/trainingen');

        $this->assertSame('xco-walking', $training->fresh()->slug);
        $this->get('/xco-walking')->assertOk()->assertSee('XCO Walking Nieuw');
    }

    public function test_deleting_training_removes_its_lessons_and_page(): void
    {
        $admin = $this->admin();
        $training = Training::where('slug', 'seniorensport')->first();
        $this->assertGreaterThan(0, $training->lessons()->count());

        $this->actingAs($admin)->delete("/admin/trainingen/{$training->id}")->assertRedirect('/admin/trainingen');

        $this->assertSame(0, Lesson::where('training_id', $training->id)->count());
        $this->get('/seniorensport')->assertNotFound();
        $this->get('/lesrooster')->assertOk()->assertDontSee('Aanmelden voor Seniorenfit');
        $this->get('/')->assertOk();
    }

    public function test_original_images_are_never_deleted(): void
    {
        $admin = $this->admin();
        $training = Training::where('slug', 'bootcamp-outdoor')->first();

        $this->actingAs($admin)->put("/admin/trainingen/{$training->id}", [
            'title' => $training->title, 'short' => 'x', 'intro' => 'x', 'sort_order' => 1, 'remove_image' => 1,
        ]);

        $this->assertNull($training->fresh()->image);
        $this->assertFileExists(public_path('images/bootcamp-outdoor.png'));
        $this->get('/bootcamp-outdoor')->assertOk();
    }

    // ── Tarieven ──

    public function test_price_crud_shows_on_prices_page(): void
    {
        $admin = $this->admin();
        $price = Price::where('title', 'Bootcamp Outdoor')->first();

        $this->actingAs($admin)->put("/admin/tarieven/{$price->id}", [
            'title' => 'Bootcamp Outdoor', 'price' => '€ 19,00', 'unit' => 'per les*', 'extra' => '10-rittenkaart € 175,-',
            'features' => "Buiten\n1 uur", 'cta' => 'Aanmelden', 'interest' => 'Bootcamp Outdoor', 'sort_order' => 1,
        ])->assertRedirect('/admin/tarieven');

        $this->get('/tarieven')->assertSee('€ 19,00')->assertSee('10-rittenkaart € 175,-')->assertDontSee('€ 17,50');

        $this->actingAs($admin)->post('/admin/tarieven', [
            'title' => 'Duo Training', 'price' => '€ 39,-', 'unit' => 'p.p. per uur*', 'features' => 'Met z\'n tweeën',
            'cta' => 'Duo aanvragen', 'interest' => '', 'highlight' => 1, 'sort_order' => 4,
        ])->assertRedirect('/admin/tarieven');
        $this->get('/tarieven')->assertSee('Duo Training')->assertSee('href="'.route('contact').'"', false);

        $this->actingAs($admin)->delete("/admin/tarieven/{$price->id}");
        $this->get('/tarieven')->assertDontSee('€ 19,00');
    }
}
