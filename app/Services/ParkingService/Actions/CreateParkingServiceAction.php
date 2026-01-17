<?php
namespace App\Services\ParkingService\Actions;

use App\Models\Parking;
use App\Models\ParkingService;
use Illuminate\Http\Request;

class CreateParkingServiceAction
{
    public function run(Request $request, $parkingId): ParkingService
    {
        $service=new ParkingService();
        $service->parking_id=$parkingId;
        $service->license_plate=$request->license_plate;
        $service->model=$request->model;
        $service->color=$request->color;
        $service->parking_start_time=$request->parking_start_time;
        $service->parking_end_time=$request->parking_end_time;
        $service->parking_spot=$request->parking_spot;
        $service->save();

        return $service;
    }

}
