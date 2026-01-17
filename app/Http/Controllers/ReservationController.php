<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Notifications\ReservationCreated;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Reservation\SaveRequest;
use App\Http\Requests\Reservation\UpdateRequest;
use App\Models\Airport;
use App\Models\Client;
use App\Models\Parking;
use Illuminate\Support\Facades\Session;

class ReservationController extends Controller
{
    public function store(SaveRequest $request, Airport $airport, Parking $parking)
    {
        $validated = $request->validated();

        if (auth()->check() && auth()->user()->isManager()) {
            $timeStart = date('Y-m-d H:i:s', strtotime($request->input('time_start')));
            $timeEnd = date('Y-m-d H:i:s', strtotime($request->input('time_end')));
        } else {
            $reservationData = Session::get('reservation_data');
            $timeStart = date('Y-m-d H:i:s', strtotime($reservationData['start-date'] . ' ' . $reservationData['start-time']));
            $timeEnd = date('Y-m-d H:i:s', strtotime($reservationData['end-date'] . ' ' . $reservationData['end-time']));
        }
       

        $client = Client::create(
            [
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'car_number' => $validated['car_number'],
                'car_model' => $validated['car_model'],
                'car_color' => $validated['car_color'],
                'payment_method' => $validated['payment_method'],
            ]
        );

        $data = [
            'airport_id' => $airport->id,
            'parking_id' => $parking->id,
            'client_id' => $client->id,
            'time_start' => $timeStart,
            'time_end' => $timeEnd,
            'price' => $validated['price'],
            'email' => $validated['email'],
            'status' => 0,
        ];

        $reservation = Reservation::create($data);

        // $manager = $reservation->parking->manager ?? new User(['name' => env('APP_NAME'), 'email' => env('MAIL_FROM_ADDRESS')]);

        // Notification::send($manager, new ReservationCreated($reservation, $manager));
        $reservationDataForSuccessPage = [
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'car_number' => $validated['car_number'],
            'car_model' => $validated['car_model'],
            'car_color' => $validated['car_color'],
            'payment_method' => $validated['payment_method'],
        ];
    
        session()->put('reservation_data_for_success_page', $reservationDataForSuccessPage);
    
        try {
            if (auth()->check() && auth()->user()->isManager()) {
                // Если пользователь аутентифицирован и является менеджером
                return redirect()->back()->with('success', 'Reservation created successfully');
            } else {
                // Если пользователь аутентифицирован, но не является менеджером
                return redirect()->route('reservations.success')->with('success', 'Reservation created successfully');
            }
        } catch (\Exception $e) {
            
            return redirect()->route('reservations.fail')->with('error', 'Failed to create reservation');
        }
        
    }
    public function update(UpdateRequest $request, Reservation $reservation)
    {
        $reservation->update($request->all());
        $clientData = $request->only(['phone', 'name', 'email', 'car_number', 'car_model', 'car_color']); 
        $reservation->client->update($clientData);
    
        return redirect()->route('parkings.reservations', ['parking' => $reservation->parking_id])->with('success', 'Reservation updated successfully');
    }
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        $reservation->client->delete();
        return redirect()->back()->with('success', 'Reservation deleted successfully');
    }
}
