<x-admin.layout title="Wachtwoord instellen" guest>
    <div class="admin-card">
        <h1 class="heading-1">Kies een wachtwoord</h1>
        <p class="admin-muted mt-2">Minimaal 10 tekens. Een zin van een paar woorden werkt prima en onthoud je makkelijk.</p>

        <form method="POST" action="{{ route('admin.password.update') }}" class="admin-form mt-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <x-admin.field name="email" label="E-mailadres">
                <input id="email" type="email" name="email" value="{{ old('email', $email) }}" class="form-input" required autocomplete="username">
            </x-admin.field>
            <x-admin.field name="password" label="Nieuw wachtwoord">
                <input id="password" type="password" name="password" class="form-input" required autofocus autocomplete="new-password" minlength="10">
            </x-admin.field>
            <x-admin.field name="password_confirmation" label="Herhaal wachtwoord">
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-input" required autocomplete="new-password" minlength="10">
            </x-admin.field>
            <button type="submit" class="btn btn-primary w-full">Wachtwoord opslaan en inloggen</button>
        </form>
    </div>
</x-admin.layout>
