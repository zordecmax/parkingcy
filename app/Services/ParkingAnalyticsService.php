<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ParkingAnalyticsService
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = (string) \config('services.google.maps_key');
    }

    /**
     * Расчет индекса давления (0.0 - 1.0)
     */
    public function calculatePressure(float $lat, float $lng, ?int $userReportedSpots = null): float
    {
        // 1. Получаем данные о трафике (Traffic Factor)
        $trafficFactor = $this->getTrafficFactor($lat, $lng);

        // 2. Crowdsource Factor (если есть данные от пользователей)
        // Допустим, 0 - мест нет, 1 - много мест
        $crowdFactor = $userReportedSpots !== null
            ? (1 - ($userReportedSpots / 50))
            : 0.5;

        // 3. Time Factor (Cyprus Specific)
        $hour = (int) \now()->format('H');
        $timeFactor = (($hour >= 8 && $hour <= 10) || ($hour >= 17 && $hour <= 19)) ? 0.9 : 0.3;

        // Итоговая формула (Weighted Average)
        $score = ($trafficFactor * 0.5) + ($crowdFactor * 0.3) + ($timeFactor * 0.2);

        return round(min(max($score, 0), 1), 2);
    }

    protected function getTrafficFactor(float $lat, float $lng): float
    {
        if ($this->apiKey === '') {
            return 0.5;
        }

        $response = Http::timeout(10)
            ->withHeaders([
                'X-Goog-Api-Key' => $this->apiKey,
                'X-Goog-FieldMask' => 'routes.duration,routes.staticDuration',
            ])
            ->post('https://routes.googleapis.com/directions/v2:computeRoutes', [
                'origin' => [
                    'location' => [
                        'latLng' => [
                            'latitude' => $lat - 0.005,
                            'longitude' => $lng - 0.005,
                        ],
                    ],
                ],
                'destination' => [
                    'location' => [
                        'latLng' => [
                            'latitude' => $lat,
                            'longitude' => $lng,
                        ],
                    ],
                ],
                'travelMode' => 'DRIVE',
                'routingPreference' => 'TRAFFIC_AWARE_OPTIMAL',
            ]);

        if ($response->successful() && isset($response['routes'][0])) {
            $realTime = $this->parseGoogleDurationSeconds((string) ($response['routes'][0]['duration'] ?? ''));
            $baseTime = $this->parseGoogleDurationSeconds((string) ($response['routes'][0]['staticDuration'] ?? ''));

            if ($realTime === null || $baseTime === null || $baseTime <= 0) {
                return 0.5;
            }

            // Если едем в 2 раза дольше базы - давление максимальное (1.0)
            return min(($realTime - $baseTime) / $baseTime, 1.0);
        }

        return 0.5;
    }

    /**
     * Диагностика: возвращает сырые данные Google Routes + расчётные значения.
     * Полезно для тестового endpoint'а.
     */
    public function getTrafficDiagnostics(float $lat, float $lng): array
    {
        if ($this->apiKey === '') {
            return [
                'ok' => false,
                'error' => 'GOOGLE_MAPS_API_KEY is not set',
            ];
        }

        $payload = [
            'origin' => [
                'location' => [
                    'latLng' => [
                        'latitude' => $lat - 0.005,
                        'longitude' => $lng - 0.005,
                    ],
                ],
            ],
            'destination' => [
                'location' => [
                    'latLng' => [
                        'latitude' => $lat,
                        'longitude' => $lng,
                    ],
                ],
            ],
            'travelMode' => 'DRIVE',
            'routingPreference' => 'TRAFFIC_AWARE_OPTIMAL',
        ];

        $response = Http::timeout(10)
            ->withHeaders([
                'X-Goog-Api-Key' => $this->apiKey,
                'X-Goog-FieldMask' => 'routes.duration,routes.staticDuration',
            ])
            ->post('https://routes.googleapis.com/directions/v2:computeRoutes', $payload);

        $json = $response->json();

        $route = $json['routes'][0] ?? null;
        $realTime = $route ? $this->parseGoogleDurationSeconds((string) ($route['duration'] ?? '')) : null;
        $baseTime = $route ? $this->parseGoogleDurationSeconds((string) ($route['staticDuration'] ?? '')) : null;

        $trafficFactor = 0.5;
        if (is_int($realTime) && is_int($baseTime) && $baseTime > 0) {
            $trafficFactor = min(($realTime - $baseTime) / $baseTime, 1.0);
        }

        return [
            'ok' => $response->successful(),
            'status' => $response->status(),
            'trafficFactor' => round(min(max($trafficFactor, 0), 1), 4),
            'durationSeconds' => $realTime,
            'staticDurationSeconds' => $baseTime,
            'request' => $payload,
            'response' => $json,
        ];
    }

    private function parseGoogleDurationSeconds(string $duration): ?int
    {
        $duration = trim($duration);
        if ($duration === '') {
            return null;
        }

        // Обычно приходит строка вида "123s" (иногда может быть "123.000s")
        $duration = rtrim($duration, "sS");
        if (!is_numeric($duration)) {
            return null;
        }

        return (int) round((float) $duration);
    }
}
