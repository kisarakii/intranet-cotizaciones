<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePerfilRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Solo usuarios autenticados (el middleware auth lo refuerza en el controller)
        return auth()->check();
    }

    public function rules(): array
    {
        $userId = auth()->id();

        return [
            'nombre'   => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'edad'     => ['required', 'integer', 'min:1', 'max:120'],
            'email'    => [
                'required', 'email', 'max:255',
                Rule::unique('usuarios', 'email')->ignore($userId, 'id'),
            ],
            // Password es opcional; si viene, confirm y mínimo 8
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'   => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'edad.required'     => 'La edad es obligatoria.',
            'edad.integer'      => 'La edad debe ser un número.',
            'edad.min'          => 'La edad mínima es 1.',
            'edad.max'          => 'La edad máxima permitida es 120.',
            'email.required'    => 'El email es obligatorio.',
            'email.email'       => 'El email no tiene un formato válido.',
            'email.unique'      => 'Este email ya está en uso.',
            'password.min'      => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'=> 'La confirmación de contraseña no coincide.',
        ];
    }
}
