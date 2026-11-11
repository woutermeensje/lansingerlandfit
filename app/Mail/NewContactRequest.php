<?php

namespace App\Mail;

use App\Models\ContactRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewContactRequest extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactRequest $contact) {}

    public function envelope(): Envelope
    {
        $subject = $this->contact->source === 'proefles'
            ? 'Nieuwe aanvraag gratis proefles'
            : 'Nieuw bericht via het contactformulier';

        return new Envelope(
            subject: $subject.' – '.$this->contact->fullName(),
            replyTo: [new Address($this->contact->email, $this->contact->fullName())],
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'mail.contact-request');
    }
}
