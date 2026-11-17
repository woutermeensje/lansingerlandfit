<x-admin.layout title="Wachtwoord vergeten" guest>
    <div class="admin-card">
        <h1 class="heading-1">Wachtwoord vergeten</h1>
        <p class="admin-muted mt-2">Vul je e-mailadres in. Je krijgt een link waarmee je een nieuw wachtwoord kiest.</p>

        <form method="POST" action="{{ route('admin.password.email') }}" class="admin-form mt-6">
            @csrf
            <x-admin.field name="email" label="E-mailadres">
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input" required autofocus autocomplete="username">
            </x-admin.field>
            <button type="submit" class="btn btn-primary w-full">Stuur link</button>
        </form>

        <p class="admin-muted mt-6 text-sm"><a href="{{ route('admin.login') }}" class="admin-link">Terug naar inloggen</a></p>
    </div>
</x-admin.layout>
