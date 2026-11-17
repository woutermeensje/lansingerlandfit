<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AdminPasswordLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Beheerders. Er is geen openbare registratie: een ingelogde beheerder voegt
 * een nieuwe beheerder toe, die per mail een link krijgt om een wachtwoord te kiezen.
 */
class AdminUserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', ['users' => User::orderBy('name')->get()]);
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        ], [
            'email.unique' => 'Er is al een beheerder met dit e-mailadres.',
        ], ['name' => 'naam', 'email' => 'e-mailadres']);

        // Willekeurig wachtwoord dat niemand kent; de nieuwe beheerder kiest zelf een wachtwoord via de mail.
        $user = User::create([...$data, 'email' => Str::lower($data['email']), 'password' => Str::random(40)]);
        $user->notify(new AdminPasswordLink(Password::createToken($user), invite: true));

        return redirect()->route('admin.users.index')
            ->with('status', "{$user->name} is toegevoegd en krijgt een mail op {$user->email} om een wachtwoord in te stellen.");
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->withErrors(['user' => 'Je kunt jezelf niet verwijderen.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', "{$user->name} is verwijderd als beheerder.");
    }
}
