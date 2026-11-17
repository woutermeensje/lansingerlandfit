<x-admin.layout title="Beheerders">
    <div class="admin-page-head">
        <div>
            <h1 class="heading-1">Beheerders</h1>
            <p class="admin-muted mt-1">Iedereen in deze lijst kan inloggen en alles in de beheeromgeving aanpassen.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Beheerder toevoegen</a>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>Naam</th><th>E-mailadres</th><th>Toegevoegd</th><th class="text-right">Acties</th></tr></thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td><span class="admin-row__title">{{ $user->name }}</span>@if ($user->is(auth()->user()))<span class="admin-badge">Jij</span>@endif</td>
                        <td>{{ $user->email }}</td>
                        <td class="whitespace-nowrap">{{ $user->created_at?->translatedFormat('j M Y') }}</td>
                        <td>
                            <div class="admin-row__actions justify-end">
                                @if ($user->is(auth()->user()))
                                    <a href="{{ route('admin.account') }}" class="btn btn-outline btn-sm">Mijn account</a>
                                @else
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" data-confirm="{{ $user->name }} verwijderen? Deze persoon kan daarna niet meer inloggen.">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Verwijderen</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin.layout>
