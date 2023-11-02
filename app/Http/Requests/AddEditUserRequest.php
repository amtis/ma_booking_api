<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEditUserRequest extends FormRequest
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
        if ($this->method() === 'DELETE') {
            return [
                'user_id' =>'required|numeric|exists:users,id'
            ];
        }

        $rules = [
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
        ];

        if ($this->method() === 'POST') {
            $rules['email'] = 'required|email|unique:users|max:255';
            $rules['password'] = 'required|min:6';
        }

        if ($this->method() === 'PUT') {
            $rules['user_id'] = 'required|numeric|exists:users,id';
        }

        return $rules;
    }
}
