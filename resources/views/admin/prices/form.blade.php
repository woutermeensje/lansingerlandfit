<x-admin.layout :title="$price->exists ? 'Tarief bewerken' : 'Tarief toevoegen'">
    <div class="admin-page-head">
        <div>
            <p class="admin-crumb"><a href="{{ route('admin.prices.index') }}" class="admin-link">Tarieven</a></p>
            <h1 class="heading-1">{{ $price->exists ? $price->title : 'Tarief toevoegen' }}</h1>
        </div>
    </div>

    <form method="POST" action="{{ $price->exists ? route('admin.prices.update', $price) : route('admin.prices.store') }}" class="admin-card admin-form">
        @csrf
        @if ($price->exists) @method('PUT') @endif

        <x-admin.field name="title" label="Naam">
            <input id="title" name="title" value="{{ old('title', $price->title) }}" class="form-input" required maxlength="100">
        </x-admin.field>

        <div class="admin-form__row">
            <x-admin.field name="price" label="Prijs" hint="Zoals het op de site moet staan, bijv. € 17,50">
                <input id="price" name="price" value="{{ old('price', $price->price) }}" class="form-input" required maxlength="30">
            </x-admin.field>
            <x-admin.field name="unit" label="Eenheid" hint="Bijv. per les* of per uur*">
                <input id="unit" name="unit" value="{{ old('unit', $price->unit) }}" class="form-input" maxlength="30">
            </x-admin.field>
        </div>

        <x-admin.field name="extra" label="Extra regel (optioneel)" hint="Bijv. 10-rittenkaart € 160,-">
            <input id="extra" name="extra" value="{{ old('extra', $price->extra) }}" class="form-input" maxlength="100">
        </x-admin.field>

        <x-admin.field name="features" label="Kenmerken" hint="Eén kenmerk per regel. Ze staan als vinkjes in het blok.">
            <textarea id="features" name="features" rows="6" class="form-input">{{ old('features', implode("\n", $price->features ?? [])) }}</textarea>
        </x-admin.field>

        <div class="admin-form__row">
            <x-admin.field name="cta" label="Knoptekst">
                <input id="cta" name="cta" value="{{ old('cta', $price->cta) }}" class="form-input" required maxlength="60">
            </x-admin.field>
            <x-admin.field name="interest" label="Knop opent contactformulier met" hint="Wordt alvast ingevuld bij &quot;Waar heb je interesse in?&quot;">
                <select id="interest" name="interest" class="form-input">
                    <option value="">Niets vooraf ingevuld</option>
                    @foreach ($interests as $interest)
                        <option value="{{ $interest }}" @selected(old('interest', $price->interest) === $interest)>{{ $interest }}</option>
                    @endforeach
                </select>
            </x-admin.field>
        </div>

        <label class="form-check">
            <input type="checkbox" name="highlight" value="1" @checked(old('highlight', $price->highlight))> Uitlichten (donker blok, iets hoger dan de rest)
        </label>

        <x-admin.field name="sort_order" label="Volgorde" hint="Lager getal = verder naar links." class="max-w-40">
            <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $price->sort_order) }}" class="form-input" required min="0" max="999">
        </x-admin.field>

        <div class="admin-form__actions">
            <button type="submit" class="btn btn-primary">{{ $price->exists ? 'Opslaan' : 'Tarief toevoegen' }}</button>
            <a href="{{ route('admin.prices.index') }}" class="btn btn-quiet">Annuleren</a>
        </div>
    </form>
</x-admin.layout>
