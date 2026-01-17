<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parking;
use App\Services\ParkingAnalyticsService;
use Illuminate\Http\Request;

class ParkingAnalyticsController extends Controller
{
    /**
     * Тестовый endpoint для проверки ответа Google Routes API по координатам парковки.
     * Доступен только в окружениях local/testing.
     */
    public function googleTraffic(Parking $parking, Request $request, ParkingAnalyticsService $analytics)
    {
        // if (!\app()->environment(['local', 'testing'])) {
        //     \abort(404);
        // }

        $lat = (float) $parking->latitude;
        $lng = (float) $parking->longitude;

        if (!$lat || !$lng) {
            return \response()->json([
                'ok' => false,
                'error' => 'Parking does not have valid latitude/longitude',
            ], 422);
        }

        $lastReport = null;
        $userReportedSpots = null;
        $report = $parking->reports()->latest()->first();
        if ($report) {
            $lastReport = [
                'id' => $report->id,
                'is_space_available' => (bool) $report->is_space_available,
                'comment' => $report->comment,
                'created_at' => \optional($report->created_at)->toISOString(),
            ];

            // Use anonymous DB report in crowd factor:
            // - if there is space -> low pressure (treat as many spots)
            // - if no space -> high pressure (treat as zero spots)
            $userReportedSpots = $report->is_space_available ? 50 : 0;
        }

        $pressure = $analytics->calculatePressure($lat, $lng, $userReportedSpots);

        return \response()->json([
            'ok' => true,
            'parking' => [
                'id' => $parking->id,
                'latitude' => $lat,
                'longitude' => $lng,
            ],
            'last_report' => $lastReport,
            'pressure' => $pressure,
            'google' => $analytics->getTrafficDiagnostics($lat, $lng),
        ]);
    }

    /**
     * Тестовый endpoint по координатам (lat/lng) без парковки.
     * Доступен только в окружениях local/testing.
     */
    public function googleTrafficByCoords(Request $request, ParkingAnalyticsService $analytics)
    {
        // if (!\app()->environment(['local', 'testing'])) {
        //     \abort(404);
        // }

        $lat = $request->query('lat');
        $lng = $request->query('lng');

        if (!is_numeric($lat) || !is_numeric($lng)) {
            return \response()->json([
                'ok' => false,
                'error' => 'Query params lat and lng are required and must be numeric',
            ], 422);
        }

        $lat = (float) $lat;
        $lng = (float) $lng;

        $userReportedSpots = $request->integer('user_reported_spots');
        $pressure = $analytics->calculatePressure($lat, $lng, $userReportedSpots);

        return \response()->json([
            'ok' => true,
            'coords' => [
                'latitude' => $lat,
                'longitude' => $lng,
            ],
            'pressure' => $pressure,
            'google' => $analytics->getTrafficDiagnostics($lat, $lng),
        ]);
    }
}
