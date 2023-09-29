<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */

    public function rules(): array
    {
        return [
            'name.unique' => 'El usuario ya existe.',
            'name.regex' => 'No se permiten números.',
            'name.required' => 'Este campo es requerido.',
            'phone.integer' => 'Solo se permiten números.',
            'phone.required' => 'Este campo es requerido.',
            'phone.unique' => 'Este número ya existe.',
            'email.required' => 'Este campo es requerido.',
            'email.unique' => 'Este correo electrónico ya existe.',
            'category.required' => 'Este campo es requerido.',
            'ci.required' => 'Este campo es requerido.',
            'ci.unique' => 'Este carnet ya esta registrado.',
        ];
    }
}
