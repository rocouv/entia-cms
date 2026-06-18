<h1>Nuevo mensaje de contacto</h1>

<p><strong>Nombre:</strong> {{ $contact['name'] }}</p>
<p><strong>Correo:</strong> {{ $contact['email'] }}</p>

@if($contact['phone'] ?? false)
    <p><strong>Telefono:</strong> {{ $contact['phone'] }}</p>
@endif

<p><strong>Mensaje:</strong></p>
<p>{!! nl2br(e($contact['message'])) !!}</p>
