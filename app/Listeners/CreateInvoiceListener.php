<?php

namespace App\Listeners;

use App\Events\ParkingServiceCreatedEvent;
use App\Models\Invoice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateInvoiceListener
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

    public function handle(ParkingServiceCreatedEvent $event)
    {
        $invoice = Invoice::create([
            'parking_service_id' => $event->parking_service->id,
            'amount' => $event->price,
            'paid' => false,
        ]);

        $invoice->invoice_id_hash = $invoice->generate_invoice_id_hash();
        $invoice->save();

        $event->result['invoice_id'] = $invoice->id;
    }
}
