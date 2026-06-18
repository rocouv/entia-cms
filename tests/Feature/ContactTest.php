<?php

use App\Mail\ContactMailable;
use App\Models\Page;
use App\Models\Section;
use App\Models\Site;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();

    config()->set('mail.contact.from_address', 'web@example.test');
    config()->set('mail.contact.from_name', 'Entia');
    config()->set('mail.contact.to_address', 'ventas@example.test');
    config()->set('mail.contact.mailer', 'resend');
});

function createContactPage(): Page
{
    $site = Site::factory()->create();
    SiteSetting::factory()->for($site)->create([
        'contact_email' => 'contacto@example.test',
    ]);

    $page = Page::factory()->for($site)->create([
        'title' => 'Inicio',
        'slug' => 'inicio',
        'is_home' => true,
        'is_published' => true,
        'show_in_navigation' => true,
    ]);

    Section::factory()->for($page)->create([
        'type' => 'contact',
        'content' => [
            'title' => 'Hablemos de tu proyecto',
            'body' => 'Cuéntanos qué necesitas y te responderemos pronto.',
            'show_form' => true,
        ],
        'sort_order' => 1,
        'is_visible' => true,
    ]);

    return $page;
}

function validContactPayload(array $overrides = []): array
{
    return array_merge([
        'name' => 'Ana Lopez',
        'email' => 'ana@example.test',
        'phone' => '+52 55 1234 5678',
        'message' => 'Quiero cotizar una nueva campaña para mi negocio.',
        'website' => null,
    ], $overrides);
}

it('shows the public contact form on visible contact sections', function () {
    createContactPage();

    $this->get('/')
        ->assertOk()
        ->assertSee('Hablemos de tu proyecto')
        ->assertSee('Enviar mensaje')
        ->assertSee('name="name"', false)
        ->assertSee('name="email"', false)
        ->assertSee('name="message"', false);
});

it('validates required contact fields', function () {
    $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.11'])
        ->from('/')
        ->post('/contacto', [])
        ->assertRedirect('/')
        ->assertSessionHasErrors(['name', 'email', 'message']);
});

it('validates the contact email format', function () {
    $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.12'])
        ->from('/')
        ->post('/contacto', validContactPayload(['email' => 'correo-invalido']))
        ->assertRedirect('/')
        ->assertSessionHasErrors(['email']);
});

it('sends a contact email with the expected payload', function () {
    Mail::fake();

    $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.13'])
        ->from('/')
        ->post('/contacto', validContactPayload())
        ->assertRedirect('/')
        ->assertSessionHas('status', 'Gracias por escribirnos. Te responderemos pronto.');

    Mail::assertSent(ContactMailable::class, function (ContactMailable $mail): bool {
        return $mail->hasTo('ventas@example.test')
            && $mail->contact['name'] === 'Ana Lopez'
            && $mail->contact['email'] === 'ana@example.test'
            && $mail->contact['phone'] === '+52 55 1234 5678'
            && $mail->contact['message'] === 'Quiero cotizar una nueva campaña para mi negocio.';
    });
});

it('silently ignores contact submissions with the honeypot filled', function () {
    Mail::fake();

    $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.14'])
        ->from('/')
        ->post('/contacto', validContactPayload(['website' => 'https://spam.example']))
        ->assertRedirect('/')
        ->assertSessionHas('status', 'Gracias por escribirnos. Te responderemos pronto.');

    Mail::assertNothingSent();
});

it('rate limits repeated contact submissions', function () {
    Mail::fake();

    for ($i = 0; $i < 3; $i++) {
        $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.15'])
            ->post('/contacto', validContactPayload([
                'email' => "ana{$i}@example.test",
            ]))
            ->assertRedirect();
    }

    $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.15'])
        ->post('/contacto', validContactPayload(['email' => 'bloqueado@example.test']))
        ->assertStatus(429);
});
