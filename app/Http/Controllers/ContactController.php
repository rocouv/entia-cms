<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMailable;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function store(ContactRequest $request): RedirectResponse
    {
        $contact = $request->validated();

        if (filled($contact['website'] ?? null)) {
            return back()->with('status', 'Gracias por escribirnos. Te responderemos pronto.');
        }

        $recipient = config('mail.contact.to_address')
            ?: SiteSetting::query()->whereNotNull('contact_email')->value('contact_email');

        if (blank($recipient)) {
            Log::warning('Contact form submission skipped because CONTACT_TO_EMAIL is not configured.');

            return back()->with('status', 'Gracias por escribirnos. Te responderemos pronto.');
        }

        try {
            Mail::mailer(config('mail.contact.mailer'))
                ->to($recipient)
                ->send(new ContactMailable($contact));
        } catch (Throwable $exception) {
            Log::error('Contact form email could not be sent.', [
                'exception' => $exception,
            ]);

            return back()->with('status', 'No pudimos enviar tu mensaje ahora. Intenta nuevamente en unos minutos.');
        }

        return back()->with('status', 'Gracias por escribirnos. Te responderemos pronto.');
    }
}
