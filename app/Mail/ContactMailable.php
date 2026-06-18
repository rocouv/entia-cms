<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array{name: string, email: string, phone?: string|null, message: string, website?: string|null}  $contact
     */
    public function __construct(public array $contact) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.contact.from_address'), config('mail.contact.from_name')),
            replyTo: [new Address($this->contact['email'], $this->contact['name'])],
            subject: 'Nuevo mensaje de contacto - '.$this->contact['name'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.contact',
        );
    }

    /**
     * @return array<int, mixed>
     */
    public function attachments(): array
    {
        return [];
    }
}
