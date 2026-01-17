<?php
namespace App\Http\Requests\Parking;

use Illuminate\Foundation\Http\FormRequest;

class SaveParkingRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Или ваша логика авторизации
    }

    public function rules()
    {
          return [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'address' => 'nullable|string',
        'phone' => 'nullable|string',
        'total_spaces' => 'nullable|integer',
        'available_spaces' => 'nullable|integer',
        'handicap_accessible' => 'nullable|integer',
        'electric_charging_stations' => 'nullable|integer',
        'can_pay_by_card' => 'nullable|boolean',
        'charging_speed' => 'nullable|integer',
        'price_per_hour' => 'nullable|numeric',
        'price_per_day' => 'nullable|numeric',
        'tariffs' => 'nullable|json',
        'link' => 'nullable|url',
        'max_vehicle_height' => 'nullable|numeric',
        'active' => 'nullable|boolean',
    ];
    }
}




