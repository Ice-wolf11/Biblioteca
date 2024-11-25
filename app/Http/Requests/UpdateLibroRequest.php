<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLibroRequest extends FormRequest
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
    public function rules()
    {
        return [
            'titulo' => 'required|string|max:255',
            'fecha_publicacion' => 'required|date',
            'portada' => 'nullable|image|max:2048',
            'categorias' => 'nullable|array',
            'categorias.*' => 'exists:categorias,id',
            'autores' => 'nullable|array|min:1',
            'autores.*' => 'exists:autores,id',
        ];
    }
    

    

}
