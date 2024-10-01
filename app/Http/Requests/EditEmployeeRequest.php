<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditEmployeeRequest extends FormRequest
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
            'name' => 'sometimes',
            'email' => 'sometimes|email|unique:users,email',
            'birthdate' => 'sometimes|date|date_format:d/m/Y'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.email' => 'Por favor, insira um endereço de email válido.',
            'email.unique' => 'Este email já está cadastrado.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'birthdate.date' => 'A data de nascimento deve ser uma data válida.',
            'birthdate.date_format' => 'A data de nascimento deve estar no formato DD/MM/YY.',
        ];
    }
}
