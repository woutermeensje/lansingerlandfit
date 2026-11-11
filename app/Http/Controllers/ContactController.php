<?php

namespace App\Http\Controllers;

use App\Mail\NewContactRequest;
use App\Models\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Honeypot tegen spam: echte bezoekers vullen dit verborgen veld niet in.
        if (filled($request->input('website'))) {
            return back()->with('status', 'Bedankt! We nemen snel contact met je op.');
        }

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'interest' => ['nullable', Rule::in(config('site.interests'))],
            'message' => ['nullable', 'string', 'max:5000'],
            'source' => ['nullable', Rule::in(['contact', 'over-ons', 'proefles'])],
        ], [], [
            'first_name' => 'voornaam',
            'last_name' => 'achternaam',
            'email' => 'e-mailadres',
            'phone' => 'telefoonnummer',
            'interest' => 'interesse',
            'message' => 'bericht',
        ]);

        $data['source'] ??= 'contact';

        $contact = ContactRequest::create($data);

        Mail::to(config('site.contact.notify'))->send(new NewContactRequest($contact));

        return back()->with('status', 'Bedankt voor je bericht! Ik neem zo snel mogelijk contact met je op.');
    }
}
