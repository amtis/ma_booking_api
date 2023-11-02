<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddEditTripRequest extends FormRequest
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
                'id' => 'required|exists:trips,id'
            ];
        }

        $rules = [
            'slug' => 'required|string|max:255|unique:trips,slug',
            'title' => 'required|max:255',
            'description' => 'nullable',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
            'location' => 'required|max:255',
            'price' => 'required|numeric'
        ];

        if ($this->method() === 'PUT') {
            $rules['id'] = ['required', 'exists:trips,id'];
            $rules['slug'] = ['required', 'string', 'max:255', Rule::unique('trips')->ignore($this->id)];
        }

        return $rules;
    }
}
