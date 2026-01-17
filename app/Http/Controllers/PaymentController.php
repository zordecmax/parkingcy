<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\ParkingService;
use App\Models\Parking;
use App\Enums\PaymentEnum;
use Stripe\Checkout\Session;
use App\Events\PaymentCreatedEvent;
use App\Http\Requests\Payment\StoreRequest;
use App\Models\Invoice;

class PaymentController extends Controller
{
    public function show(Parking $parking)
    {
        return view('parkings.payments.show', compact('parking'));
    }

    public function store(StoreRequest $request, Parking $parking)
    {
        $lineItems = [];
        $lineItems[] = [
            'price_data' => [
                'currency' => 'EUR',
                'product_data' => [
                    'name' => $parking->name,
                ],
                'unit_amount' => intval($request->price * 100)
            ],
            'quantity' => 1,
        ];

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        header("HTTP/1.1 303 See Other");

        $event = new PaymentCreatedEvent($parking, $request->price);

        event($event);

        $parkingService = ParkingService::findOrFail($event->result['parking_service_id'])->with('invoice');

        $invoice = $parkingService->invoice;

        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' =>  url(route('payment.success', ['invoice_id_hash' => $invoice->invoice_id_hash])),
            'cancel_url' =>  url(route('payment.failure')),
        ]);

        return redirect(route('parkings.qr.show', ['parking' => $parking, 'session_url' => $session->url]));
    }

    public function success(Invoice $invoice)
    {
        $invoice->update([
            'paid' => PaymentEnum::paid,
        ]);

        return view('parkings.payments.success');
    }

    public function failure()
    {
        return view('parkings.payments.failure');
    }
}
