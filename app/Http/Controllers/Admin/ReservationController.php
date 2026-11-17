<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Lessen die bezoekers via het lesrooster hebben gereserveerd.
 */
class ReservationController extends Controller
{
    public function index(Request $request): View
    {
        $past = $request->query('periode') === 'geweest';

        $reservations = Reservation::query()
            ->when($past,
                fn ($q) => $q->whereDate('date', '<', today())->orderByDesc('date')->orderByDesc('starts_at'),
                fn ($q) => $q->whereDate('date', '>=', today())->orderBy('date')->orderBy('starts_at'),
            )
            ->orderBy('name')
            ->paginate(50)->withQueryString();

        return view('admin.reservations.index', [
            'reservations' => $reservations,
            'past' => $past,
            'counts' => [
                'komend' => Reservation::whereDate('date', '>=', today())->count(),
                'geweest' => Reservation::whereDate('date', '<', today())->count(),
            ],
        ]);
    }

    public function destroy(Reservation $reservation): RedirectResponse
    {
        $reservation->delete();

        return back()->with('status', "De reservering van {$reservation->name} voor {$reservation->lesson_name} is verwijderd.");
    }
}
