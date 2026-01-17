<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ParkingReport;
use App\Http\Requests\Api\ParkingReport\SaveRequest;
use App\Models\User;

class ParkingReportController extends Controller
{
    public function store(SaveRequest $request)
    {
        $user = User::where('uuid', $request->user_uuid)->first();

        if (!$user) {
            $user = new User();
            $user->generate($request->user_uuid);
        }

        $validated = $request->validated();
        $lastReportCurrentParking = ParkingReport::where('parking_id', $validated['parking_id'])->orderBy('created_at', 'desc')->first();
        $data['report'] = get_last_parking_report($lastReportCurrentParking);
        $data['parking_id'] = $validated['parking_id'];


        $report = ParkingReport::create([
            'parking_id' => $validated['parking_id'],
            'user_id' => $user->id,
            'is_space_available' => $validated['is_space_available'],
        ]);

        $data['report'] = get_last_parking_report($report);

        return wrap_response(201, 'OK', $data);
    }

    public function showLastParkingReport($parkingId)
    {
        $lastReport = ParkingReport::where('parking_id', $parkingId)->orderBy('created_at', 'desc')->first();

        $response = get_last_parking_report($lastReport);
        if ($response) {
            return wrap_response(200, 'OK', $response);
        }
        return wrap_response(404, 'Not Found');
    }
}
