<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        $result = [];

        foreach ($cities as $city) {
            $result[] = [
                'id' => $city->id,
                'name' => $city->name,
                'slug' => $city->slug,
                'link' => route('map.cities.show', $city->slug),
            ];
        }

        return wrap_response(200, 'OK', $result);
    }
}
