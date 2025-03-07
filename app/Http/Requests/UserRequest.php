<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'erros' => $validator->errors(),
        ], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user');
        return [
            'name'=> 'required',
            'email'=> 'required|email|unique:users,email,' . ($userId ? $userId->id : null),
            'password'=> 'required|min:6'
        ];
    }

    public function messages() : array
    {
        return [
            'name.required' => 'Campo nome é obrigatório!',
            'email.required' => 'Campo email é obrigatório!',
            'email.email' => 'Campo email deve ser válido!',
            'email.unique' => 'O e-mail já está em uso!',
            'password.required' => 'Campo senha é obrigatório!',
            'password.min' => 'Senha deve ter no mínimo :min caracteres!',
        ];
    }
}
