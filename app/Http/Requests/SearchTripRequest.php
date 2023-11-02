<?php

namespace App\Http\Requests;

use App\Models\Trip;
use Illuminate\Foundation\Http\FormRequest;

class SearchTripRequest extends FormRequest
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
            'order_by' => 'nullable|in:' . implode(',', Trip::ORDER_BY),
            'order_type' => 'nullable|in:asc,desc',
            'price_from' => 'nullable|numeric',
            'price_to' => 'nullable|numeric',
            'search' => 'nullable|string|min:1|max:255',
            'location' => 'nullable|string|min:1|max:255',
        ];
    }
}
