<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TrainingController extends Controller
{
    public function index(): View
    {
        return view('admin.trainings.index', [
            'trainings' => Training::withCount('lessons')->orderBy('sort_order')->orderBy('title')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.trainings.form', ['training' => new Training([
            'sort_order' => (Training::max('sort_order') ?? 0) + 1,
        ])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge(['slug' => Str::slug($request->input('slug') ?: $request->input('title'))]);

        $data = $this->validated($request, new Training);
        $data['interest'] = $data['title'];

        $training = Training::create($data);

        return redirect()->route('admin.trainings.index')
            ->with('status', "Training \"{$training->title}\" is toegevoegd en staat op ".url($training->slug).'.');
    }

    public function edit(Training $training): View
    {
        return view('admin.trainings.form', ['training' => $training]);
    }

    public function update(Request $request, Training $training): RedirectResponse
    {
        // De slug (URL) is na het aanmaken vast, zodat links en Google-resultaten blijven werken.
        $request->request->remove('slug');

        $training->update($this->validated($request, $training));

        return redirect()->route('admin.trainings.index')->with('status', "Training \"{$training->title}\" is bijgewerkt.");
    }

    public function destroy(Training $training): RedirectResponse
    {
        $lessons = $training->lessons()->count();

        $this->deleteImage($training->image);
        $this->deleteImage($training->card_image);
        $training->delete();

        return redirect()->route('admin.trainings.index')->with('status', "Training \"{$training->title}\" is verwijderd"
            .($lessons ? ", samen met {$lessons} ".($lessons === 1 ? 'les' : 'lessen').' uit het lesrooster.' : '.'));
    }

    private function validated(Request $request, Training $training): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:100'],
            'short' => ['required', 'string', 'max:300'],
            'intro' => ['required', 'string', 'max:1000'],
            'body' => ['nullable', 'string', 'max:10000'],
            'benefits' => ['nullable', 'string', 'max:2000'],
            'seo_title' => ['nullable', 'string', 'max:70'],
            'seo_description' => ['nullable', 'string', 'max:160'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_image' => ['nullable', 'boolean'],
        ];

        if (! $training->exists) {
            $rules['slug'] = ['required', 'string', 'max:80', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'unique:trainings,slug', Rule::notIn($this->reservedSlugs())];
        }

        $data = $request->validate($rules, [
            'slug.not_in' => 'Deze URL wordt al door een andere pagina van de site gebruikt. Kies een andere.',
            'slug.unique' => 'Er is al een training met deze URL.',
        ], [
            'title' => 'naam',
            'slug' => 'URL',
            'short' => 'korte omschrijving',
            'intro' => 'introductie',
            'body' => 'tekst',
            'benefits' => 'voordelen',
            'seo_title' => 'SEO-titel',
            'seo_description' => 'SEO-omschrijving',
            'sort_order' => 'volgorde',
            'image' => 'afbeelding',
        ]);

        // Tekst: alinea's gescheiden door een witregel. Voordelen: één per regel.
        $data['body'] = $this->paragraphs($data['body'] ?? '');
        $data['benefits'] = $this->lines($data['benefits'] ?? '');

        if ($request->hasFile('image')) {
            $this->deleteImage($training->image);
            $this->deleteImage($training->card_image);
            $data['image'] = 'storage/'.$request->file('image')->store('trainingen', 'public');
            $data['card_image'] = null;
        } elseif ($request->boolean('remove_image')) {
            $this->deleteImage($training->image);
            $this->deleteImage($training->card_image);
            $data['image'] = null;
            $data['card_image'] = null;
        }

        unset($data['remove_image']);

        return $data;
    }

    /** URL's die al door andere pagina's worden gebruikt (lesrooster, tarieven, locaties, ...). */
    private function reservedSlugs(): array
    {
        return collect(Route::getRoutes()->getRoutes())
            ->map(fn ($route) => explode('/', trim($route->uri(), '/'))[0])
            ->reject(fn ($segment) => $segment === '' || str_starts_with($segment, '{'))
            ->merge(array_keys(config('site.locations')))
            ->unique()->values()->all();
    }

    private function paragraphs(string $text): array
    {
        return collect(preg_split('/\R\s*\R/', trim($text)))->map(fn ($p) => trim(preg_replace('/\s*\R\s*/', ' ', $p)))->filter()->values()->all();
    }

    private function lines(string $text): array
    {
        return collect(preg_split('/\R/', trim($text)))->map(fn ($l) => trim($l, " \t-•"))->filter()->values()->all();
    }

    /** Alleen geüploade afbeeldingen verwijderen, nooit de vaste afbeeldingen in public/images. */
    private function deleteImage(?string $path): void
    {
        if ($path && str_starts_with($path, 'storage/')) {
            Storage::disk('public')->delete(Str::after($path, 'storage/'));
        }
    }
}
