<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('usuario'); // viene como parámetro del resource

        return [
            'nombre'    => ['required','string','max:255'],
            'apellido'  => ['required','string','max:255'],
            'edad'      => ['required','integer','min:0'],
            'email'     => [
                'required','string','email','max:255',
                Rule::unique('usuarios','email')->ignore($id)
            ],
            // en edición, password es opcional; si viene, valida y se hashea en controller
            'password'  => ['nullable','string','min:8','confirmed'],
            'admin'     => ['nullable','boolean'],
        ];
    }
}
