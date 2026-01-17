<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use Illuminate\Http\Request;

class QRCodeController extends Controller
{
    public function show(Parking $parking, Request $request)
    {
        $session_url = $request->session_url;
        return view('parkings.qr.show', compact('parking', 'session_url'));
    }
}
