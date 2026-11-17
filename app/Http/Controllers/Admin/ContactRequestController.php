<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Alle ingevulde formulieren: contact, gratis proefles en de landingspagina's.
 */
class ContactRequestController extends Controller
{
    public function index(Request $request): View
    {
        $source = array_key_exists($request->query('bron'), ContactRequest::SOURCES) ? $request->query('bron') : null;

        return view('admin.contact-requests.index', [
            'requests' => ContactRequest::query()
                ->when($source, fn ($q) => $q->where('source', $source))
                ->latest()->latest('id')
                ->paginate(25)->withQueryString(),
            'counts' => ContactRequest::selectRaw('source, count(*) as total')->groupBy('source')->pluck('total', 'source'),
            'source' => $source,
        ]);
    }

    public function destroy(ContactRequest $contactRequest): RedirectResponse
    {
        $contactRequest->delete();

        return back()->with('status', "De aanvraag van {$contactRequest->fullName()} is verwijderd.");
    }
}
