<x-admin.layout :title="$training->exists ? 'Training bewerken' : 'Training toevoegen'">
    <div class="admin-page-head">
        <div>
            <p class="admin-crumb"><a href="{{ route('admin.trainings.index') }}" class="admin-link">Trainingen</a></p>
            <h1 class="heading-1">{{ $training->exists ? $training->title : 'Training toevoegen' }}</h1>
        </div>
        @if ($training->exists)
            <a href="{{ route('training', $training->slug) }}" class="btn btn-outline" target="_blank" rel="noopener">Bekijk pagina</a>
        @endif
    </div>

    <form method="POST" action="{{ $training->exists ? route('admin.trainings.update', $training) : route('admin.trainings.store') }}" enctype="multipart/form-data" class="admin-card admin-form">
        @csrf
        @if ($training->exists) @method('PUT') @endif

        <x-admin.field name="title" label="Naam">
            <input id="title" name="title" value="{{ old('title', $training->title) }}" class="form-input" required maxlength="100">
        </x-admin.field>

        @if ($training->exists)
            <div class="admin-field">
                <span class="form-label">URL</span>
                <p class="text-sm">{{ url($training->slug) }}</p>
                <p class="form-hint">De URL ligt vast, zodat bestaande links en Google-resultaten blijven werken.</p>
            </div>
        @else
            <x-admin.field name="slug" label="URL (optioneel)" hint="Leeg laten = gemaakt van de naam, bijvoorbeeld &quot;Bootcamp Outdoor&quot; wordt /bootcamp-outdoor. Kan later niet meer veranderen.">
                <div class="form-prefix">
                    <span class="form-prefix__text">{{ parse_url(url('/'), PHP_URL_HOST) }}/</span>
                    <input id="slug" name="slug" value="{{ old('slug') }}" class="form-input" maxlength="80" placeholder="bijv. hardlopen-voor-beginners">
                </div>
            </x-admin.field>
        @endif

        <x-admin.field name="short" label="Korte omschrijving" hint="Eén zin. Staat op de kaartjes in het overzicht van trainingen.">
            <input id="short" name="short" value="{{ old('short', $training->short) }}" class="form-input" required maxlength="300">
        </x-admin.field>

        <x-admin.field name="intro" label="Introductie" hint="Staat bovenaan de trainingspagina, onder de titel.">
            <textarea id="intro" name="intro" rows="3" class="form-input" required maxlength="1000">{{ old('intro', $training->intro) }}</textarea>
        </x-admin.field>

        <x-admin.field name="body" label="Tekst" hint="Zet een witregel tussen alinea's.">
            <textarea id="body" name="body" rows="9" class="form-input">{{ old('body', implode("\n\n", $training->body ?? [])) }}</textarea>
        </x-admin.field>

        <x-admin.field name="benefits" label="Voordelen" hint="Eén voordeel per regel. Ze staan als vinkjes op de pagina.">
            <textarea id="benefits" name="benefits" rows="5" class="form-input">{{ old('benefits', implode("\n", $training->benefits ?? [])) }}</textarea>
        </x-admin.field>

        <x-admin.field name="image" label="Afbeelding" hint="JPG, PNG of WEBP, maximaal 5 MB. Liggend formaat werkt het best.">
            @if ($training->image)
                <img src="{{ asset($training->card_image ?: $training->image) }}" alt="" class="admin-thumb">
            @endif
            <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp" class="form-input">
            @if ($training->image)
                <label class="form-check mt-2">
                    <input type="checkbox" name="remove_image" value="1" @checked(old('remove_image'))> Afbeelding verwijderen
                </label>
            @endif
        </x-admin.field>

        <fieldset class="admin-fieldset">
            <legend class="form-label">Google (SEO)</legend>
            <x-admin.field name="seo_title" label="SEO-titel (optioneel)" hint="Maximaal 70 tekens. Leeg laten = de naam van de training.">
                <input id="seo_title" name="seo_title" value="{{ old('seo_title', $training->seo_title) }}" class="form-input" maxlength="70">
            </x-admin.field>
            <x-admin.field name="seo_description" label="SEO-omschrijving (optioneel)" hint="Maximaal 160 tekens. Leeg laten = de introductie.">
                <textarea id="seo_description" name="seo_description" rows="2" class="form-input" maxlength="160">{{ old('seo_description', $training->seo_description) }}</textarea>
            </x-admin.field>
        </fieldset>

        <x-admin.field name="sort_order" label="Volgorde" hint="Lager getal = eerder in het menu en de overzichten." class="max-w-40">
            <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $training->sort_order) }}" class="form-input" required min="0" max="999">
        </x-admin.field>

        <div class="admin-form__actions">
            <button type="submit" class="btn btn-primary">{{ $training->exists ? 'Opslaan' : 'Training toevoegen' }}</button>
            <a href="{{ route('admin.trainings.index') }}" class="btn btn-quiet">Annuleren</a>
        </div>
    </form>
</x-admin.layout>
