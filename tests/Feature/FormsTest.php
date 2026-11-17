<?php

namespace Tests\Feature;

use App\Mail\NewContactRequest;
use App\Mail\NewReservation;
use App\Models\Lesson;
use App\Support\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class FormsTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('emptyContactEmails')]
    public function test_contact_form_stores_and_mails_without_a_cc(?string $contactEmail): void
    {
        Mail::fake();
        config(['site.contact.notify' => 'admin@example.com', 'site.contact.cc' => $contactEmail]);

        $this->from('/contact')->post('/contact', [
            'first_name' => 'Anna',
            'last_name' => 'de Vries',
            'email' => 'anna@example.com',
            'interest' => 'XCO Walking',
            'message' => 'Ik wil graag meedoen.',
        ])->assertRedirect('/contact')->assertSessionHas('status');

        $this->assertDatabaseHas('contact_requests', ['email' => 'anna@example.com', 'source' => 'contact']);
        Mail::assertSent(NewContactRequest::class, function (NewContactRequest $mail): bool {
            $this->assertEmpty($mail->cc);

            return $mail->hasTo('admin@example.com');
        });
    }

    /**
     * @return array<string, array{?string}>
     */
    public static function emptyContactEmails(): array
    {
        return [
            'not configured' => [null],
            'empty' => [''],
        ];
    }

    public function test_contact_form_sends_a_cc_to_the_contact_email(): void
    {
        Mail::fake();
        config([
            'site.contact.notify' => 'admin@example.com',
            'site.contact.cc' => 'cindy@lansingerlandfit.nl',
        ]);

        $this->from('/contact')->post(route('contact.store'), [
            'first_name' => 'Anna',
            'last_name' => 'de Vries',
            'email' => 'anna@example.com',
            'message' => 'Ik ontvang graag meer informatie.',
        ])->assertRedirect('/contact')->assertSessionHas('status');

        $this->assertDatabaseHas('contact_requests', ['email' => 'anna@example.com', 'source' => 'contact']);
        Mail::assertSent(NewContactRequest::class, fn (NewContactRequest $mail): bool => $mail->hasTo('admin@example.com')
            && $mail->hasCc('cindy@lansingerlandfit.nl'));
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
        $lesson = Schedule::find((string) Lesson::where('name', 'Bootcamp Outdoor')->where('day', 5)->value('id'));
        $date = Schedule::upcomingDates($lesson)->first()->toDateString();

        $this->from('/lesrooster')->post('/reserveren', [
            'lesson_id' => $lesson['id'],
            'date' => $date,
            'name' => 'Piet',
            'email' => 'piet@example.com',
        ])->assertRedirect('/lesrooster')->assertSessionHas('status');

        $this->assertDatabaseHas('reservations', ['lesson_id' => $lesson['id'], 'email' => 'piet@example.com']);
        Mail::assertSent(NewReservation::class, fn ($m) => $m->hasTo('piet@example.com'));
    }

    public function test_reservation_rejects_wrong_weekday(): void
    {
        $lesson = Schedule::find((string) Lesson::where('name', 'Bootcamp Outdoor')->where('day', 5)->value('id'));
        $wrong = Schedule::upcomingDates($lesson)->first()->addDay()->toDateString();

        $this->post('/reserveren', [
            'lesson_id' => $lesson['id'],
            'date' => $wrong,
            'name' => 'Piet',
            'email' => 'piet@example.com',
        ])->assertSessionHasErrors('date');

        $this->assertDatabaseCount('reservations', 0);
    }
}
