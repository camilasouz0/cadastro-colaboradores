<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'birthdate' => 'required|date|date_format:d/m/Y',
            'profile' => 'in:employee,admin',
            'cpf' => 'required',
            'city' => 'required',
            'state' => 'required'
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
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
            'email.unique' => 'Este email já está cadastrado.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'birthdate.required' => 'O campo data de nascimento é obrigatório.',
            'birthdate.date' => 'A data de nascimento deve ser uma data válida.',
            'birthdate.date_format' => 'A data de nascimento deve estar no formato DD/MM/YY.',
            'profile.in' => 'O campo perfil deve ser "employee" ou "admin".',
            'cpf.required' => 'O campo cpf é obrigatório.',
            'city.required' => 'O campo cidade é obrigatório.',
            'state.required' => 'O campo Estado é obrigatório.'
        ];
    }
}
