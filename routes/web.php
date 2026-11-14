<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ReservationController;
use App\Support\Seo;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/lesrooster', [PageController::class, 'schedule'])->name('lesrooster');
Route::get('/tarieven', [PageController::class, 'prices'])->name('tarieven');
Route::get('/trainingen', [PageController::class, 'trainings'])->name('trainingen');
Route::get('/over-ons', [PageController::class, 'about'])->name('over-ons');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/gratis-proefles', [PageController::class, 'trial'])->name('proefles');
Route::get('/duo-training', [PageController::class, 'duo'])->name('duo-training');
Route::get('/caloriebehoefte-calculator', [PageController::class, 'calorieCalculator'])->name('caloriebehoefte-calculator');
Route::get('/sportparken-lansingerland', [PageController::class, 'sportParks'])->name('sportparken');
Route::get('/afval-begeleiding', [PageController::class, 'weightLoss'])->name('afval-begeleiding');
Route::get('/voedings-advies', [PageController::class, 'nutrition'])->name('voedings-advies');

Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');

Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:6,1')->name('contact.store');
Route::post('/reserveren', [ReservationController::class, 'store'])->middleware('throttle:10,1')->name('reservations.store');

// Trainingen en locaties staan, net als op de oude site, direct onder de root.
Route::get('/{training}', [PageController::class, 'training'])
    ->whereIn('training', array_keys(config('site.trainings')))
    ->name('training');
Route::get('/{location}', [PageController::class, 'location'])
    ->whereIn('location', array_keys(config('site.locations')))
    ->name('locatie');

// Oude WordPress-links.
Route::permanentRedirect('/zwangerschapstraining', '/zwangerschapsfitness');
Route::permanentRedirect('/lidmaatschap', '/tarieven');

Route::get('/sitemap', fn () => view('pages.sitemap', [
    'groups' => Seo::entries()->groupBy('group'),
]))->name('sitemap');

Route::get('/sitemap.xml', fn () => response()
    ->view('sitemap', ['entries' => Seo::entries()])
    ->header('Content-Type', 'application/xml; charset=UTF-8')
)->name('sitemap.xml');

Route::get('/robots.txt', fn () => response(implode("\n", [
    'User-agent: *',
    config('seo.indexable') ? 'Allow: /' : 'Disallow: /',
    '',
    'Sitemap: '.Seo::url('sitemap.xml'),
])."\n")->header('Content-Type', 'text/plain; charset=UTF-8'))->name('robots');
