<?php

namespace App\Listeners;

use App\Events\ParkingServiceCreatedEvent;
use App\Events\PaymentCreatedEvent;
use App\Models\ParkingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateParkingServiceListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PaymentCreatedEvent  $event
     * @return void
     */
    public function handle(PaymentCreatedEvent $event)
    {
        $ParkingService = ParkingService::create([
            'parking_id' => $event->parking->id,
            'parking_start_time' => now(),
        ]);

        $event->result['parking_service_id'] = $ParkingService->id;

        event(new ParkingServiceCreatedEvent($ParkingService, $event->price, $event->result));
    }
}
