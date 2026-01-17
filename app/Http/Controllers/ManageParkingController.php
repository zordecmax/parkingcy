<?php

namespace App\Http\Controllers;

use App\Enums\PaymentEnum;
use App\Http\Requests\Manage\ManageParkingRequest;
use App\Models\Invoice;
use App\Models\Parking;
use App\Models\ParkingService;
use App\Services\Invoice\invoiceService;
use App\Services\ParkingService\ParkingManageService;
use App\Services\QrCode\QrCode;
use Illuminate\Http\Request;

class ManageParkingController extends Controller
{
    public function store(ManageParkingRequest $request, Parking $parking,ParkingManageService $parkingManageService,InvoiceService $invoiceService,QrCode $parkingManage)
    {
        $parkingService = $parkingManageService->createParkingService()->run($request, $parking->id);
        $invoice=$invoiceService->createInvoice()->run($request,$parkingService);
        $qr=$parkingManage->qrCodeCreate()->run($request,$parking,$invoice);

        return redirect()->back()->with('success', 'The record has been successfully created!');
    }
    public function update(ParkingService $service,Parking $parking, ManageParkingRequest $request,ParkingManageService $parkingManageService,InvoiceService $invoiceService,QrCode $parkingManage)
    {
        $service=$parkingManageService->updateParkingService()->run($request, $service->id);
        $invoice=$invoiceService->updateInvoice()->run($request, $service);
        $qr=$parkingManage->qrCodeCreate()->run($request,$parking,$invoice);

        return redirect()->back()->with('success', 'The record has been successfully created!');
    }
    public function destroy( ParkingService $service)
    {
        $service->delete();

        return redirect()->back()->with('success', 'The record has been successfully created!');
    }
}
