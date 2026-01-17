<?php

namespace App\Http\Controllers;

use App\Http\Requests\Parking\SaveParkingRequest;
use App\Models\ParkingService;
use Illuminate\Http\Request;
use App\Models\Parking;
use App\Models\ParkingSchedule;
use Exception;
use Illuminate\Support\Facades\Auth;

class ParkingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $parking = null;

        try {
            $parking = $user->parking;

            if ($parking) {
                $parking->occupancy_percentage = $this->calculateOccupancyPercentage($parking);
            }
        } catch (\Throwable $th) {
            new Exception($th->getMessage());
        }

        return view('manager.dashboard', compact('parking'));
    }

    public function reservations(Parking $parking)
    {
        $reservations = $parking->reservations()->get();
        return view('parkings.reservations.index', compact('reservations'));
    }


    private function calculateOccupancyPercentage(Parking $parking)
    {
        if ($parking->total_spaces == 0) {
            return 0;
        }
        return ($parking->total_spaces - $parking->available_spaces) / $parking->total_spaces * 100;
    }


    public function store(SaveParkingRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['manager_id'] = Auth::id();
        Parking::create($validatedData);

        return redirect()->route('manager.dashboard')->with('success', 'Parking created successfully');
    }


    public function show(Parking $parking)
    {
        return view('parkings.show', compact('parking'));
    }


    public function create()
    {
        $parking = new Parking(); // Создание нового объекта Parking


        return view('parkings.create', compact('parking'));
    }


    public function edit($id)
    {
        // Находим парковку по переданному идентификатору
        $parking = Parking::find($id) ?? new Parking();

        // Получаем расписание для этой парковки, если оно есть
        $schedule = ParkingSchedule::where('parking_id', $id)->first();

        return view('parkings.edit', compact('parking', 'schedule'));
    }
    public function update(SaveParkingRequest $request, $id)
    {
        $parking = Parking::findOrFail($id);

        // Обновляем данные парковки, исключая данные о расписании из запроса
        $parking->update($request->except('schedule'));

        // Если есть расписание в запросе
        if ($request->has('schedule')) {
            $scheduleData = $request->input('schedule');
            $scheduleData['parking_id'] = $parking->id; // Устанавливаем parking_id

            // Дни недели
            $daysOfWeek = ['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su'];

            // Проверяем, выбраны ли выходные для каждого дня недели
            foreach ($daysOfWeek as $day) {
                if (isset($scheduleData["{$day}_is_off"]) && $scheduleData["{$day}_is_off"] == 1) {
                    // Если выбраны выходные, обнуляем данные расписания
                    $scheduleData["{$day}_time_start"] = null;
                    $scheduleData["{$day}_time_end"] = null;
                    $scheduleData["{$day}_break_start"] = null;
                    $scheduleData["{$day}_break_end"] = null;
                }
            }

            // Обновляем или создаем новую запись расписания
            $schedule = ParkingSchedule::updateOrCreate(['parking_id' => $parking->id], $scheduleData);
        }
        if ($request->has('action') && $request->input('action') == 'save') {
            return redirect()->route('parkings.edit', $id)->with('success', 'Parking and schedule updated successfully');
        }

        return redirect()->route('manager.dashboard', $id)->with('success', 'Parking and schedule updated successfully');
    }




    public function destroy($id)
    {
        $parking = Parking::findOrFail($id);
        $parking->delete();

        return redirect()->route('manager.dashboard')->with('success', 'Parking deleted successfully');
    }


    public function parking(Parking $parking)
    {
        return view('parkings.parking', compact('parking'));
    }
    
}
