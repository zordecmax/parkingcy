<?php

namespace App\Http\Requests\Manage;

use Illuminate\Foundation\Http\FormRequest;

class ManageParkingRequest extends FormRequest
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
            'license_plate' => 'nullable|string|max:15',
            'model' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'parking_start_time' => 'nullable|date|after:now',
            'parking_end_time' => 'nullable|date|after:parking_start_time',
            'parking_spot' => 'nullable|string|max:10',
            'amount' => 'required|numeric|min:0',
            
        ];
    }
    public function messages()
    {
        return [
            'license_plate.string' => 'The license plate must be a string.',
            'license_plate.max' => 'The license plate may not be greater than 15 characters.',

            'model.string' => 'The model must be a string.',
            'model.max' => 'The model may not be greater than 50 characters.',

            'color.string' => 'The color must be a string.',
            'color.max' => 'The color may not be greater than 20 characters.',
            'parking_time_start.after' => 'The time start must be after the current time.',
            'parking_time_end.after' => 'The time end must be after the time start.',

            'parking_spot.string' => 'The parking spot must be a string.',
            'parking_spot.max' => 'The parking spot may not be greater than 10 characters.',
            'amount.numeric' => 'The amount must be a number.',
            'amount.min' => 'The amount must be at least 0.',
          
        ];
    }

}
