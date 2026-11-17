<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin.account', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ], [], ['name' => 'naam', 'email' => 'e-mailadres']);

        $user->update([...$data, 'email' => Str::lower($data['email'])]);

        return back()->with('status', 'Je gegevens zijn opgeslagen.');
    }

    public function password(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(10)],
        ], [], ['current_password' => 'huidige wachtwoord', 'password' => 'nieuwe wachtwoord']);

        $request->user()->update(['password' => $request->input('password')]);

        $request->session()->regenerate();

        return back()->with('status', 'Je wachtwoord is gewijzigd.');
    }
}
