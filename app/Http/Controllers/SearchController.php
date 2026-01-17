<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Search\SaveRequest;

class SearchController extends Controller
{
    public function index(Airport $airport)
    {
        abort_unless(Session::has('reservation_data'), 404);

        $reservationData = Session::get('reservation_data');
        $days = $this->calculateDays($reservationData);

        foreach ($airport->parkings as $parking) {
            $longRangeParkingPrice = $parking->long_range_parking_prices->where('days_start', '<=', $days)->where('days_end', '>=', $days)->first();

            
            if ($longRangeParkingPrice) {
                $parking->total_price = $longRangeParkingPrice->price * $days;
            } else {
                $parking->total_price = 0;
            }
        }

        return view('parkings.airports.search', compact('airport'));
    }

    public function store(SaveRequest $request, Airport $airport)
    {
        $validated = $request->validated();
        $parkings = $airport->parkings;

        Session::put('reservation_data', $validated);

        return redirect()->route('parkings.airport.search.index', $airport);
    }

    public function calculateDays(array $data): int
    {
        $startDate = $data['start-date'];
        $startTime = $data['start-time'];
        $endDate = $data['end-date'];
        $endTime = $data['end-time'];

        $start = Carbon::createFromFormat('Y-m-d H:i', $startDate . ' ' . $startTime);
        $end = Carbon::createFromFormat('Y-m-d H:i', $endDate . ' ' . $endTime);

        $days = $start->diffInDays($end, false);

        if ($start->diffInHours($end) % 24 > 0) {
            $days++;
        }

        return $days;
    }
}
