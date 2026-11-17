<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Training;
use App\Support\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LessonController extends Controller
{
    public function index(): View
    {
        return view('admin.lessons.index', ['days' => Schedule::byDay()]);
    }

    public function create(Request $request): View
    {
        return $this->form(new Lesson([
            'day' => (int) $request->query('dag', 1),
            'starts_at' => '09:00',
            'ends_at' => '10:00',
        ]));
    }

    public function store(Request $request): RedirectResponse
    {
        $lesson = Lesson::create($this->validated($request));

        return redirect()->route('admin.lessons.index')->with('status', "Les \"{$lesson->name}\" op ".config('site.days')[$lesson->day].' is toegevoegd.');
    }

    public function edit(Lesson $lesson): View
    {
        return $this->form($lesson);
    }

    public function update(Request $request, Lesson $lesson): RedirectResponse
    {
        $lesson->update($this->validated($request));

        return redirect()->route('admin.lessons.index')->with('status', "Les \"{$lesson->name}\" is bijgewerkt.");
    }

    public function destroy(Lesson $lesson): RedirectResponse
    {
        $lesson->delete();

        return redirect()->route('admin.lessons.index')->with('status', "Les \"{$lesson->name}\" op ".config('site.days')[$lesson->day].' is verwijderd.');
    }

    private function form(Lesson $lesson): View
    {
        return view('admin.lessons.form', [
            'lesson' => $lesson,
            'trainings' => Training::orderBy('sort_order')->orderBy('title')->pluck('title', 'id'),
            'locations' => Lesson::distinct()->orderBy('location')->pluck('location'),
        ]);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'training_id' => ['required', 'exists:trainings,id'],
            'name' => ['nullable', 'string', 'max:100'],
            'day' => ['required', 'integer', 'between:1,7'],
            'starts_at' => ['required', 'date_format:H:i'],
            'ends_at' => ['required', 'date_format:H:i', 'after:starts_at'],
            'location' => ['required', 'string', 'max:150'],
        ], [
            'ends_at.after' => 'De eindtijd moet na de begintijd liggen.',
        ], [
            'training_id' => 'training',
            'name' => 'naam',
            'day' => 'dag',
            'starts_at' => 'begintijd',
            'ends_at' => 'eindtijd',
            'location' => 'locatie',
        ]);

        // Geen eigen naam ingevuld? Dan heet de les zoals de training.
        $data['name'] = filled($data['name'] ?? null) ? $data['name'] : Training::find($data['training_id'])->title;

        return $data;
    }
}
