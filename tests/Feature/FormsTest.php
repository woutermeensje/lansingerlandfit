<?php

namespace Tests\Feature;

use App\Mail\NewContactRequest;
use App\Mail\NewReservation;
use App\Support\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class FormsTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_stores_and_mails(): void
    {
        Mail::fake();

        $this->from('/contact')->post('/contact', [
            'first_name' => 'Anna',
            'last_name' => 'de Vries',
            'email' => 'anna@example.com',
            'interest' => 'XCO Walking',
            'message' => 'Ik wil graag meedoen.',
        ])->assertRedirect('/contact')->assertSessionHas('status');

        $this->assertDatabaseHas('contact_requests', ['email' => 'anna@example.com', 'source' => 'contact']);
        Mail::assertSent(NewContactRequest::class);
    }

    public function test_contact_form_validates(): void
    {
        $this->post('/contact', ['email' => 'geen-email'])
            ->assertSessionHasErrors(['first_name', 'last_name', 'email']);
    }

    public function test_honeypot_blocks_spam(): void
    {
        Mail::fake();

        $this->post('/contact', ['website' => 'spam', 'first_name' => 'x'])->assertSessionHas('status');

        $this->assertDatabaseCount('contact_requests', 0);
        Mail::assertNothingSent();
    }

    public function test_reservation_for_upcoming_lesson(): void
    {
        Mail::fake();
        $lesson = Schedule::find('vr-bootcamp');
        $date = Schedule::upcomingDates($lesson)->first()->toDateString();

        $this->from('/lesrooster')->post('/reserveren', [
            'lesson_id' => 'vr-bootcamp',
            'date' => $date,
            'name' => 'Piet',
            'email' => 'piet@example.com',
        ])->assertRedirect('/lesrooster')->assertSessionHas('status');

        $this->assertDatabaseHas('reservations', ['lesson_id' => 'vr-bootcamp', 'email' => 'piet@example.com']);
        Mail::assertSent(NewReservation::class, fn ($m) => $m->hasTo('piet@example.com'));
    }

    public function test_reservation_rejects_wrong_weekday(): void
    {
        $lesson = Schedule::find('vr-bootcamp');
        $wrong = Schedule::upcomingDates($lesson)->first()->addDay()->toDateString();

        $this->post('/reserveren', [
            'lesson_id' => 'vr-bootcamp',
            'date' => $wrong,
            'name' => 'Piet',
            'email' => 'piet@example.com',
        ])->assertSessionHasErrors('date');

        $this->assertDatabaseCount('reservations', 0);
    }
}
