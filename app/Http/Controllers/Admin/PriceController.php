<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Support\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PriceController extends Controller
{
    public function index(): View
    {
        return view('admin.prices.index', ['prices' => Price::orderBy('sort_order')->orderBy('id')->get()]);
    }

    public function create(): View
    {
        return $this->form(new Price([
            'cta' => 'Aanvragen',
            'sort_order' => (Price::max('sort_order') ?? 0) + 1,
        ]));
    }

    public function store(Request $request): RedirectResponse
    {
        $price = Price::create($this->validated($request));

        return redirect()->route('admin.prices.index')->with('status', "Tarief \"{$price->title}\" is toegevoegd.");
    }

    public function edit(Price $price): View
    {
        return $this->form($price);
    }

    public function update(Request $request, Price $price): RedirectResponse
    {
        $price->update($this->validated($request));

        return redirect()->route('admin.prices.index')->with('status', "Tarief \"{$price->title}\" is bijgewerkt.");
    }

    public function destroy(Price $price): RedirectResponse
    {
        $price->delete();

        return redirect()->route('admin.prices.index')->with('status', "Tarief \"{$price->title}\" is verwijderd.");
    }

    private function form(Price $price): View
    {
        return view('admin.prices.form', ['price' => $price, 'interests' => Site::interests()]);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'price' => ['required', 'string', 'max:30'],
            'unit' => ['nullable', 'string', 'max:30'],
            'extra' => ['nullable', 'string', 'max:100'],
            'features' => ['nullable', 'string', 'max:2000'],
            'cta' => ['required', 'string', 'max:60'],
            'interest' => ['nullable', Rule::in(Site::interests())],
            'highlight' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
        ], [], [
            'title' => 'naam',
            'price' => 'prijs',
            'unit' => 'eenheid',
            'extra' => 'extra regel',
            'features' => 'kenmerken',
            'cta' => 'knoptekst',
            'interest' => 'interesse',
            'sort_order' => 'volgorde',
        ]);

        $data['features'] = collect(preg_split('/\R/', trim($data['features'] ?? '')))
            ->map(fn ($l) => trim($l, " \t-•"))->filter()->values()->all();
        $data['highlight'] = $request->boolean('highlight');

        return $data;
    }
}
