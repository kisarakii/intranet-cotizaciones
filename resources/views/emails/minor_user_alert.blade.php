@component('mail::message')
# Alerta: Usuario menor de edad

Se ha **{{ $event === 'created' ? 'creado' : 'actualizado' }}** un usuario con **edad < 18**.

@component('mail::panel')
**Nombre:** {{ $usuario->nombre }} {{ $usuario->apellido }}  
**Edad:** {{ $usuario->edad }}  
**Email:** {{ $usuario->email }}  
**Token:** {{ $usuario->token }}  
**Es administrador:** {{ $usuario->admin ? 'Sí' : 'No' }}  
**ID:** {{ $usuario->id }}
@endcomponent

> Este aviso se envía automáticamente para fines de control y cumplimiento.

Gracias,  
{{ config('app.name') }}
@endcomponent
