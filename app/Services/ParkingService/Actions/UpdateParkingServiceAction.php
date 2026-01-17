<?php
namespace App\Services\ParkingService\Actions;

use App\Models\Parking;
use App\Models\ParkingService;
use Illuminate\Http\Request;

class UpdateParkingServiceAction
{
    public function run(Request $request, $serviceId): ParkingService
    {
        $service = ParkingService::findOrFail($serviceId);
        $service->license_plate = $request->license_plate;
        $service->model = $request->model;
        $service->color = $request->color;
        $service->parking_start_time = $request->parking_start_time;
        $service->parking_end_time = $request->parking_end_time;
        $service->parking_spot = $request->parking_spot;
        $service->save();

        return $service;
    }
}
