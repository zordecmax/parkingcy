<?php

namespace App\Http\Controllers\Api;

use App\Models\Parking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Parking\ParkingService;

class ParkingController extends Controller
{
    public function index(ParkingService $service, Request $request)
    {
        $query = Parking::query()
            ->where('active', 1)
            ->with(['schedule', 'reports']);

        if ($request->has('connector_types')) {
            $connectorTypes = $request->input('connector_types');

            if (!empty($connectorTypes)) {
                $query->whereHas('connectorTypes', function ($q) use ($connectorTypes) {
                    $q->whereIn('connector_type_id', $connectorTypes);
                });
            }
        }

        if ($request->has('charging_speed')) {
            $chargingSpeeds = $request->input('charging_speed');

            if (!empty($chargingSpeeds)) {
                $chargingSpeeds = array_map('intval', $chargingSpeeds);
                $query->whereIn('charging_speed', $chargingSpeeds);
            }
        }

        if ($request->has('max_vehicle_height')) {
            if ($request->input('max_vehicle_height') >= 1.6) {
                $query->where('max_vehicle_height', '>=', $request->input('max_vehicle_height'))
                    ->orWhereNull('max_vehicle_height');
            }
        }


        // if ($request->location) {
        //     $location = $request->input('location');
        //     $lat = $location['lat'];
        //     $lng = $location['lng'];
        //     $radius = $location['radius'] ?? 1;

        //     $haversine = "(6371 * acos(cos(radians($lat)) 
        //                         * cos(radians(latitude)) 
        //                         * cos(radians(longitude) - radians($lng)) 
        //                         + sin(radians($lat)) 
        //                         * sin(radians(latitude))))";

        //     $query->select('*')
        //         ->selectRaw("{$haversine} AS distance")
        //         ->having('distance', '<', $radius)
        //         ->orderBy('distance');
        // }

        if ($request->has('handicap_accessible')) {
            $query->where('handicap_accessible', $request->input('handicap_accessible'));
        }

        if ($request->has('electric_charging_stations')) {
            $query->where('electric_charging_stations', '>=', $request->input('electric_charging_stations'));
        }

        if ($request->has('can_pay_by_card')) {
            $query->where('can_pay_by_card', $request->input('can_pay_by_card'));
        }

        $parkings = $query->get();

        $result = $service->getParkings()->run($parkings);

        return wrap_response(200, 'OK', $result);
    }

    public function filter(ParkingService $service, Request $request)
    {
        $query = Parking::query()->where('active', 1)->with('schedule');
        if ($request->has('handicap_accessible')) {
            $query->where('handicap_accessible', $request->input('handicap_accessible'));
        }

        if ($request->has('electric_charging_stations')) {
            $query->where('electric_charging_stations', '>=', $request->input('electric_charging_stations'));
        }

        if ($request->has('can_pay_by_card')) {
            $query->where('can_pay_by_card', $request->input('can_pay_by_card'));
        }

        if ($request->has('charging_speed')) {
            $query->where('charging_speed', $request->input('charging_speed'));
        }

        if ($request->has('max_vehicle_height')) {
            $query->where('vehicle_height', '>=', $request->input('max_vehicle_height'));
        }

        $parkings = $query->get();


        $result = $service->getParkings()->run($parkings);
        return response()->json($result);
    }
}
