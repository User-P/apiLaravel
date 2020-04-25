@component('mail::message')
# Hola {{$user->name}}

Tu correo electronico ha sido actualizado. Por favor verificala tu cuenta usando el siguiente botón:
@component('mail::button', ['url' => route('verify',$user->verification_token)])
Verificar
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
