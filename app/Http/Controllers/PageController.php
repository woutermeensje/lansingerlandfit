<?php

namespace App\Http\Controllers;

use App\Support\Schedule;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'featured' => collect(config('site.trainings'))->only(['personal-training', 'xco-walking', 'bedrijfsbootcamp']),
            'trainings' => config('site.trainings'),
        ]);
    }

    public function schedule(): View
    {
        return view('pages.lesrooster', ['days' => Schedule::byDay()]);
    }

    public function prices(): View
    {
        return view('pages.tarieven', ['prices' => config('site.prices')]);
    }

    public function trainings(): View
    {
        return view('pages.trainingen', [
            'trainings' => config('site.trainings'),
            'locations' => config('site.locations'),
            'days' => Schedule::byDay(),
        ]);
    }

    public function training(string $slug): View
    {
        $training = config("site.trainings.$slug") ?? abort(404);

        return view('pages.training', [
            'slug' => $slug,
            'training' => $training,
            'lessons' => Schedule::forTraining($slug),
            'others' => collect(config('site.trainings'))->except($slug)->take(3),
        ]);
    }

    public function location(string $slug): View
    {
        $location = config("site.locations.$slug") ?? abort(404);

        $lessons = Schedule::lessons()->filter(
            fn (array $l) => str_contains(strtolower($l['location']), strtolower($location['title']))
        )->values();

        return view('pages.locatie', compact('slug', 'location', 'lessons'));
    }

    public function about(): View
    {
        return view('pages.over-ons');
    }

    public function contact(): View
    {
        return view('pages.contact', ['interest' => request()->query('interesse')]);
    }

    public function trial(): View
    {
        return view('pages.gratis-proefles');
    }

    public function duo(): View
    {
        return view('pages.duo-training');
    }

    public function calorieCalculator(): View
    {
        return view('pages.caloriebehoefte-calculator');
    }

    public function sportParks(): View
    {
        return view('pages.sportparken-lansingerland', ['parks' => config('site.parks')]);
    }

    public function weightLoss(): View
    {
        return view('pages.afval-begeleiding');
    }

    public function nutrition(): View
    {
        return view('pages.voedings-advies');
    }
}
