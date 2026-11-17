<x-admin.layout title="Inloggen" guest>
    <div class="admin-card">
        <h1 class="heading-1">Inloggen</h1>
        <p class="admin-muted mt-2">Beheeromgeving van {{ config('site.name') }}.</p>

        <form method="POST" action="{{ route('admin.login.store') }}" class="admin-form mt-6">
            @csrf
            <x-admin.field name="email" label="E-mailadres">
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input" required autofocus autocomplete="username">
            </x-admin.field>
            <x-admin.field name="password" label="Wachtwoord">
                <input id="password" type="password" name="password" class="form-input" required autocomplete="current-password">
            </x-admin.field>
            <label class="form-check">
                <input type="checkbox" name="remember" value="1" @checked(old('remember'))> Ingelogd blijven op dit apparaat
            </label>
            <button type="submit" class="btn btn-primary w-full">Inloggen</button>
        </form>

        <p class="admin-muted mt-6 text-sm"><a href="{{ route('admin.password.request') }}" class="admin-link">Wachtwoord vergeten?</a></p>
    </div>
</x-admin.layout>
