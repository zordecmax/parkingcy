<?php

namespace App\Services\Parking\Actions;

use App\Models\Parking;
use App\Models\ParkingReport;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class GetParkingsAction
{
    public function run(Collection $parkings): array
    {
        $result = [];

        foreach ($parkings as $parking) {

            $schedule = $parking->schedule ? array_diff_key(
                $parking->schedule->toArray(),
                array_flip(['id', 'parking_id', 'created_at', 'updated_at'])
            ) : null;

            $report = $parking->reports->sortByDesc('created_at')->first();

            $result[] = [
                'id' => $parking->id,
                'name' => $parking->name,
                'description' => $parking->description,
                'lat' => $parking->latitude,
                'price_per_hour' => $parking->price_per_hour,
                'tariff' => $parking->tariff,
                'lng' => $parking->longitude,
                'address' => $parking->address,
                'phone' => $parking->phone,
                'total_spaces' => $parking->total_spaces,
                'available_spaces' => $parking->available_spaces,
                'handicap_accessible' => $parking->handicap_accessible,
                'electric_charging_stations' => $parking->electric_charging_stations,
                'can_by_card' => $parking->can_pay_by_card,
                'charging_speed' => $parking->charging_speed,
                'price_per_day' => $parking->price_per_day,
                'max_vehicle_height' => $parking->max_vehicle_height,
                'link' => $parking->link,
                'schedule' => $schedule,
                'report' => get_last_parking_report($report),
            ];
        }
        return $result;
    }
}
