<x-admin.layout title="Mijn account">
    <div class="admin-page-head">
        <h1 class="heading-1">Mijn account</h1>
    </div>

    <div class="admin-stack">
        <form method="POST" action="{{ route('admin.account.update') }}" class="admin-card admin-form">
            @csrf @method('PUT')
            <h2 class="heading-2">Gegevens</h2>
            <x-admin.field name="name" label="Naam">
                <input id="name" name="name" value="{{ old('name', $user->name) }}" class="form-input" required maxlength="100" autocomplete="name">
            </x-admin.field>
            <x-admin.field name="email" label="E-mailadres" hint="Hiermee log je in.">
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" required maxlength="255" autocomplete="username">
            </x-admin.field>
            <div class="admin-form__actions">
                <button type="submit" class="btn btn-primary">Opslaan</button>
            </div>
        </form>

        <form method="POST" action="{{ route('admin.account.password') }}" class="admin-card admin-form">
            @csrf @method('PUT')
            <h2 class="heading-2">Wachtwoord wijzigen</h2>
            <x-admin.field name="current_password" label="Huidige wachtwoord">
                <input id="current_password" type="password" name="current_password" class="form-input" required autocomplete="current-password">
            </x-admin.field>
            <x-admin.field name="password" label="Nieuw wachtwoord" hint="Minimaal 10 tekens.">
                <input id="password" type="password" name="password" class="form-input" required autocomplete="new-password" minlength="10">
            </x-admin.field>
            <x-admin.field name="password_confirmation" label="Herhaal nieuw wachtwoord">
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-input" required autocomplete="new-password" minlength="10">
            </x-admin.field>
            <div class="admin-form__actions">
                <button type="submit" class="btn btn-primary">Wachtwoord wijzigen</button>
            </div>
        </form>
    </div>
</x-admin.layout>
