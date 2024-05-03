<?php

namespace App\Http\Requests;

use App\Enums\AccommodationType;
use Illuminate\Foundation\Http\FormRequest;

class AccommodationRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'occupancy' => ['required', 'integer', 'min:1'],
            'is_active' => ['required', 'boolean'],
            'type' => ['required', 'string', 'in:' . implode(AccommodationType::all())]
        ];
    }
}
