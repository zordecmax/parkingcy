<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use App\Enums\UserRolesEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AirportController extends Controller
{
    public function show(Airport $airport)
    {
        if (Auth::user()) {
            if (Auth::user()->role->id === UserRolesEnum::admin->value || Auth::user()->role->id === UserRolesEnum::manager->value) {
                return view('parkings.airports.show', compact('airport'));
            }
        }
        return redirect()->back();
    }

    public function search(Airport $airport, Request $request)
    {
        return view('parkings.airports.search');
    }
}
