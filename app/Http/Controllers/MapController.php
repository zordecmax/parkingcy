<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Parking;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function city(City $city)
    {
        return view('map.cities.show', compact('city'));
    }

    public function parking(City $city, Parking $parking)
    {
        return view('map.parkings.show', compact('city', 'parking'));
    }
}
