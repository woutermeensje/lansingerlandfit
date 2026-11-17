<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use App\Models\Lesson;
use App\Models\Price;
use App\Models\Reservation;
use App\Models\Training;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'counts' => [
                'lessons' => Lesson::count(),
                'trainings' => Training::count(),
                'prices' => Price::count(),
            ],
            'reservations' => Reservation::whereDate('date', '>=', today())
                ->orderBy('date')->orderBy('starts_at')->limit(15)->get(),
            'contacts' => ContactRequest::latest()->limit(10)->get(),
        ]);
    }
}
