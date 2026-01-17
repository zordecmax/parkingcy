<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        $parkingService = ParkingService::findOrFail($event->result['parking_service_id']);
        $parkingService->load('invoice');

        $invoice = $parkingService->invoice;

        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' =>  url("/payment/success/" . $invoice->invoice_id_hash),
            'cancel_url' =>  url(route('payment.failure')),
        ]);

        $invoice->update([
            'payment_link' => $session->url,
        ]);

        $modal = view('components.qr-modal', ['title' => $parkingService->name, 'url' => $session->url])->render();

        return response()->json([
            'error' => 0,
            'data' => compact('modal')
        ], 200);
    }
}
