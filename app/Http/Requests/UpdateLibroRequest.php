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
    public function rules(): array
    {
        $libro = $this->route('libro');
        $libroid = $libro->id;
        return [
            'titulo' => 'required|max:255|unique:libros,titulo,' . $libroid,
            'fecha_publicacion' => 'nullable|date',
            'portada' => 'nullable|image|mimes:png,jpg,jpeg|max:2048,'.$libroid,
            'autores' => 'nullable|exists:autores,id,'.$libroid,
            'categorias' => 'nullable|array|exists:categorias,id,'.$libroid,
        ];
    }
}
