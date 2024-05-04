<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CalendarSearchRequest extends FormRequest
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
            'checkin' => ['required', 'date', 'after_or_equal:today'],
            'checkout' => ['required', 'date', 'after:checkin'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => [
                'nullable', 'numeric',
                Rule::when($this->filled('min_price'),'gte:min_price')
            ],
            'adult_count' => ['required', 'integer', 'min:1', 'max:20'],
            'child_count' => ['required', 'integer', 'min:0', 'max:20'],
            'infant_count' => ['required', 'integer', 'min:0', 'max:10'],
        ];
    }
}
