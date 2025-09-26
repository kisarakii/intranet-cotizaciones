<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCotizacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Autenticación se maneja por middleware; aquí no se hace lógica de permisos
        return true;
    }

    public function rules(): array
    {
        return [
            'fecha_emision'          => ['required', 'date'],
            'items'                  => ['required', 'array', 'min:1'],
            'items.*.producto_sku'   => ['required', 'string', 'exists:productos,sku'],
            'items.*.cantidad'       => ['required', 'integer', 'min:1'],
            // No aceptamos 'precio_unitario' del cliente; se toma del catálogo en el Service
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Debe agregar al menos un producto.',
            'items.min'      => 'Debe agregar al menos un producto.',
        ];
    }
}
