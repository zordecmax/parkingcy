<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    public function index()
    {
        $airports = [];

        foreach (Airport::all() as $airport) {
            $airports[] = [
                'id' => $airport->id,
                'name' => $airport->name,
                'url' => route('parkings.airport.show', $airport->slug),
            ];
        }

        return wrap_response(200, 'OK', $airports);
    }
}
