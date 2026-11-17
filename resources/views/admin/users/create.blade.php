<x-admin.layout title="Beheerder toevoegen">
    <div class="admin-page-head">
        <div>
            <p class="admin-crumb"><a href="{{ route('admin.users.index') }}" class="admin-link">Beheerders</a></p>
            <h1 class="heading-1">Beheerder toevoegen</h1>
            <p class="admin-muted mt-1">De nieuwe beheerder krijgt een mail met een link om zelf een wachtwoord te kiezen.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.users.store') }}" class="admin-card admin-form">
        @csrf
        <x-admin.field name="name" label="Naam">
            <input id="name" name="name" value="{{ old('name') }}" class="form-input" required maxlength="100" autocomplete="off">
        </x-admin.field>
        <x-admin.field name="email" label="E-mailadres">
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input" required maxlength="255" autocomplete="off">
        </x-admin.field>
        <div class="admin-form__actions">
            <button type="submit" class="btn btn-primary">Toevoegen en uitnodiging sturen</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-quiet">Annuleren</a>
        </div>
    </form>
</x-admin.layout>
