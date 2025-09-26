<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        // La autorización fina la maneja la policy y el middleware can:admin
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'    => ['required','string','max:255'],
            'apellido'  => ['required','string','max:255'],
            'edad'      => ['required','integer','min:0'],
            'email'     => ['required','string','email','max:255','unique:usuarios,email'],
            'password'  => ['required','string','min:8','confirmed'],
            'admin'     => ['nullable','boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Este correo ya está registrado.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ];
    }
}
