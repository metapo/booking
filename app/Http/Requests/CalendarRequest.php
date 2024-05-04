<?php

namespace App\Http\Requests;

use App\Models\Calendar;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CalendarRequest extends FormRequest
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
            'accommodation_id' => ['required', 'exists:accommodations,id'],
            'from_date' => ['required', 'date', 'before_or_equal:to_date', 'after_or_equal:today'],
            'to_date' => ['required', 'date', 'after_or_equal:from_date'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'adult_price' => ['required', 'numeric', 'min:0'],
            'child_price' => ['required', 'numeric', 'min:0'],
            'infant_price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $accommodationId = $this->input('accommodation_id');
            $fromDate = Carbon::parse($this->input('from_date'));
            $toDate = Carbon::parse($this->input('to_date'));

            $numberOfDays = $fromDate->diffInDays($toDate) + 1;
            if ($numberOfDays > 30) {
                $validator->errors()->add('to_date', 'Date range exceeds the 30-day limit.');
            }

            $conflictingDates = Calendar::where('accommodation_id', $accommodationId)
                ->whereBetween('date', [$fromDate, $toDate])
                ->exists();

            if ($conflictingDates) {
                $validator->errors()->add('date', 'The combination of accommodation and date range already exists.');
            }
        });
    }
}
