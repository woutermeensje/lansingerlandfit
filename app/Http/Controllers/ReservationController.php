<?php

namespace App\Http\Controllers;

use App\Mail\NewReservation;
use App\Models\Reservation;
use App\Support\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ReservationController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'lesson_id' => ['required', Rule::in(collect(config('site.schedule'))->pluck('id'))],
            'date' => ['required', 'date_format:Y-m-d'],
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
        ], [], ['date' => 'datum', 'name' => 'naam', 'email' => 'e-mailadres']);

        $lesson = Schedule::find($data['lesson_id']);

        $allowed = Schedule::upcomingDates($lesson, 8)->map->toDateString();
        if (! $allowed->contains($data['date'])) {
            throw ValidationException::withMessages(['date' => 'Kies een geldige datum voor deze les.']);
        }

        $reservation = Reservation::firstOrCreate(
            ['lesson_id' => $lesson['id'], 'date' => $data['date'], 'email' => strtolower($data['email'])],
            [
                'lesson_name' => $lesson['name'],
                'starts_at' => $lesson['from'],
                'ends_at' => $lesson['to'],
                'location' => $lesson['location'],
                'name' => $data['name'],
            ],
        );

        if ($reservation->wasRecentlyCreated) {
            Mail::to($reservation->email)
                ->bcc(config('site.contact.notify'))
                ->send(new NewReservation($reservation));
        }

        return back()->with('status', "Je reservering voor {$lesson['name']} op {$reservation->date->translatedFormat('l j F')} is ontvangen. Je ontvangt een bevestiging per e-mail.");
    }
}
