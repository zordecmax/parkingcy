<?php

namespace App\Http\Controllers\Api;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Enums\ReservationStatusesEnum;

class ReservationController extends Controller
{
    public function updateStatus(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(ReservationStatusesEnum::getValues())),
        ]);

        $reservation->update([
            'status' => $request->status
        ]);

        return wrap_response(200, 'OK', []);
    }
}
