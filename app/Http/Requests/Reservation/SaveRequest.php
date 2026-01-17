<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class SaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'car_number' => 'nullable|string|max:255',
            'car_model' => 'nullable|string|max:255',
            'car_color' => 'nullable|string|max:255',
            'payment_method' => 'required|in:cash,online',
            'price' => 'required|numeric',
            'time_start' => 'nullable|date|after:now', 
            'time_end' => 'nullable|date|after:time_start',
        ];
    }
/**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'price.required' => 'The price field is required.',
            'phone.required_without' => 'The phone field is required when email is not present.',
            'email.required_without' => 'The email field is required when phone is not present.',
            'time_start.after' => 'The time start must be after the current time.',
            'time_end.after' => 'The time end must be after the time start.',
        ];
    }
    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->sometimes('phone', 'required_without:email', function ($input) {
            return empty($input->email);
        });

        $validator->sometimes('email', 'required_without:phone', function ($input) {
            return empty($input->phone);
        });
    }
}
