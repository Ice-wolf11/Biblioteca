<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDevolucioneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fecha' => 'required|date', // Validación para la fecha
            'detalle' => 'required|max:255',
            'extraviado' => 'nullable', 
            'id_prestamo'=>'required',// Campo obligatorio, máximo 255 caracteres
            'monto' => [
                'nullable', // No es obligatorio
                'numeric', // Debe ser un número
                'regex:/^\d{1,3}(\.\d{1,2})?$/' // Máximo 3 dígitos antes del punto y 2 decimales
            ],
        ];

    }

    /**
     * Get custom messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'El campo fecha debe ser una fecha válida.',
            'detalle.required' => 'El detalle es obligatorio.',
            'detalle.max' => 'El detalle no debe exceder los 255 caracteres.',
            'monto.numeric' => 'El monto debe ser un número.',
            'monto.regex' => 'El monto debe tener hasta 3 dígitos antes del punto y hasta 2 decimales.',
        ];
    }
}
