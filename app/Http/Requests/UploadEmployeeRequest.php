<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadEmployeeRequest extends FormRequest
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
            'file' => 'required|file|mimes:csv|max:2048'
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'file.required' => 'O arquivo é obrigatório.',
            'file.file' => 'Você deve enviar um arquivo válido.',
            'file.mimes' => 'O arquivo deve ser do tipo CSV.',
            'file.max' => 'O arquivo não pode ser maior que 2MB.'
        ];
    }
}
