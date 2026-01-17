<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            
            'email' =>'nullable|email|max:255',
            'time_start' => 'date|after:now', 
            'time_end' => 'date|after:time_start',
            'price' => 'nullable|numeric|min:0',

            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'car_number' => 'nullable|string|max:255',
            'car_model' => 'nullable|string|max:255',
            'car_color' => 'nullable|string|max:255',
         
            
        ];
    }

    public function messages()
    {
        return [
   
            'email.email' => 'The email must be a valid email address.',
            'time_start.after' => 'The time start must be after the current time.',
            'time_end.after' => 'The time end must be after the time start.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price must be at least 0.',
        ];
    }
}