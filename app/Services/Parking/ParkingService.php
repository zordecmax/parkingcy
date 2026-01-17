<?php

namespace App\Services\Parking;

use App\Services\Parking\Actions\GetParkingsAction;

class ParkingService
{
    public function getParkings(): GetParkingsAction
    {
        return app(GetParkingsAction::class);
    }
}
