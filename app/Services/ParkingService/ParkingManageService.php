<?php
namespace App\Services\ParkingService;

use App\Services\ParkingService\Actions\CreateParkingServiceAction;
use App\Services\ParkingService\Actions\UpdateParkingServiceAction;
class ParkingManageService
{
    public function createParkingService(): CreateParkingServiceAction
    {
      return app(CreateParkingServiceAction::class);
    }
    public function updateParkingService(): UpdateParkingServiceAction
    {
      return app(UpdateParkingServiceAction::class);
    } 
 }
