<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
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
            'nombre' => ['string', 'max:50'],
            'correo' => ['string', 'email', 'max:50', 'unique:usuarios,correo,' . $this->route('usuario')->id],
            'apellidos' => ['string', 'max:100'],
            'sexo' => ['string', 'max:1'],
        ];
    }
}
