<?php

use Carbon\Carbon;
use App\Models\ParkingReport;
use Symfony\Component\HttpFoundation\JsonResponse;

function wrap_response(int $code, string $message, ?array $data = []): JsonResponse
{
    $result = compact('code', 'message');

    $result = array_merge($result, compact('data'));

    return response()->json($result, $code);
}


function get_last_parking_report(ParkingReport|null $report): array|null
{
    if ($report) {
        $differenceInMinutes = max(1, Carbon::now()->diffInMinutes($report->created_at));

        if ($differenceInMinutes <= 15) {
            $message = $differenceInMinutes . " minutes ago ";
            if ($report->is_space_available) {
                $message .= "there were free parking lots here";
            } else {
                $message .= "there was no free parking here";
            }

            return [
                'is_space_available' => $report->is_space_available,
                'message' => $message,
            ];
        }
    }

    return null;
}
 function renderSchedule($parking)
{
    $days = [
        'mo' => 'Monday',
        'tu' => 'Tuesday',
        'we' => 'Wednesday',
        'th' => 'Thursday',
        'fr' => 'Friday',
        'sa' => 'Saturday',
        'su' => 'Sunday'
    ];

    $output = '<ul class="p-0 m-0">';
    foreach ($days as $short => $full) {
        $timeStart = $parking->schedule->{$short . '_time_start'};
        $timeEnd = $parking->schedule->{$short . '_time_end'};
        $breakStart = $parking->schedule->{$short . '_break_start'};
        $breakEnd = $parking->schedule->{$short . '_break_end'};

        if ($timeStart || $timeEnd) {
            $output .= '<li class="d-flex flex-start">' . $full . ': ';
            if ($timeStart && $timeEnd && $timeStart->format('H:i') == '00:00' && $timeEnd->format('H:i') == '23:59') {
                $output .= '24h';
            } else {
                $output .= ($timeStart ? $timeStart->format('H:i') : 'N/A') . ' - ' . ($timeEnd ? $timeEnd->format('H:i') : 'N/A');
                if ($breakStart && $breakEnd) {
                    $output .= ' (Break: ' . $breakStart->format('H:i') . ' - ' . $breakEnd->format('H:i') . ')';
                }
            }
            $output .= '</li>';
        } else {
            $output .= '<li class="d-flex flex-start">' . $full . ': No schedule available</li>';
        }
    }
    $output .= '</ul>';

    return $output;
}