<x-admin.layout :title="$lesson->exists ? 'Les bewerken' : 'Les toevoegen'">
    <div class="admin-page-head">
        <div>
            <p class="admin-crumb"><a href="{{ route('admin.lessons.index') }}" class="admin-link">Lesrooster</a></p>
            <h1 class="heading-1">{{ $lesson->exists ? 'Les bewerken' : 'Les toevoegen' }}</h1>
        </div>
    </div>

    <form method="POST" action="{{ $lesson->exists ? route('admin.lessons.update', $lesson) : route('admin.lessons.store') }}" class="admin-card admin-form">
        @csrf
        @if ($lesson->exists) @method('PUT') @endif

        <x-admin.field name="training_id" label="Training" hint="Bepaalt de kleur in het rooster en naar welke trainingspagina de les linkt.">
            <select id="training_id" name="training_id" class="form-input" required>
                <option value="">Kies een training</option>
                @foreach ($trainings as $id => $title)
                    <option value="{{ $id }}" @selected((int) old('training_id', $lesson->training_id) === $id)>{{ $title }}</option>
                @endforeach
            </select>
        </x-admin.field>

        <x-admin.field name="name" label="Naam in het rooster (optioneel)" hint="Leeg laten = de naam van de training. Bijvoorbeeld &quot;Seniorenfit&quot; bij de training Seniorensport.">
            <input id="name" name="name" value="{{ old('name', $lesson->name) }}" class="form-input" maxlength="100">
        </x-admin.field>

        <x-admin.field name="day" label="Dag">
            <select id="day" name="day" class="form-input" required>
                @foreach (config('site.days') as $number => $label)
                    <option value="{{ $number }}" @selected((int) old('day', $lesson->day) === $number)>{{ $label }}</option>
                @endforeach
            </select>
        </x-admin.field>

        <div class="admin-form__row">
            <x-admin.field name="starts_at" label="Begintijd">
                <input id="starts_at" type="time" name="starts_at" value="{{ old('starts_at', $lesson->starts_at) }}" class="form-input" required step="300">
            </x-admin.field>
            <x-admin.field name="ends_at" label="Eindtijd">
                <input id="ends_at" type="time" name="ends_at" value="{{ old('ends_at', $lesson->ends_at) }}" class="form-input" required step="300">
            </x-admin.field>
        </div>

        <x-admin.field name="location" label="Locatie" hint="Noem de plaats (bijv. Nootdorp of Berkel en Rodenrijs), dan verschijnt de les ook op de locatiepagina.">
            <input id="location" name="location" value="{{ old('location', $lesson->location) }}" class="form-input" required maxlength="150" list="locations">
            <datalist id="locations">
                @foreach ($locations as $location)
                    <option value="{{ $location }}">
                @endforeach
            </datalist>
        </x-admin.field>

        <div class="admin-form__actions">
            <button type="submit" class="btn btn-primary">{{ $lesson->exists ? 'Opslaan' : 'Les toevoegen' }}</button>
            <a href="{{ route('admin.lessons.index') }}" class="btn btn-quiet">Annuleren</a>
        </div>
    </form>
</x-admin.layout>
