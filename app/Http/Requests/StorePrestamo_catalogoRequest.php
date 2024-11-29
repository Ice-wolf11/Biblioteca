<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrestamo_catalogoRequest extends FormRequest
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
            'fecha_inicio' => 'required|date',
            'fecha_fin' => [
                'required',
                'date',
                'after_or_equal:fecha_inicio',
                function ($attribute, $value, $fail) {
                    $fechaInicio = $this->input('fecha_inicio');
                    $maxFechaFin = date('Y-m-d', strtotime($fechaInicio . ' +14 days'));

                    if ($value > $maxFechaFin) {
                        $fail('La fecha de fin no puede ser mayor a 14 días después de la fecha de inicio.');
                    }
                },
            ],
            'id_persona' => 'required|exists:personas,id',
            'id_copia' => 'required|exists:copia_libros,id',
        ];
    }

    /**
     * Mensajes personalizados para las reglas de validación.
     */
    public function messages(): array
    {
        return [
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'id_persona.required' => 'El ID del libro es obligatorio.',
            'id_persona.exists' => 'El libro seleccionado no existe.',
            'id_copia.required' => 'El ID de la copia es obligatorio.',
            'id_copia.exists' => 'La copia seleccionada no existe.',
        ];
    }
}
