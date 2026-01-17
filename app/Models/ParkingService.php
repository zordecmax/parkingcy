<?php

namespace App\Models;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class ParkingService
 *
 * @property int $id
 * @property int $parking_id
 * @property string $license_plate
 * @property string $model
 * @property string $color
 * @property \Illuminate\Support\Carbon $parking_start_time
 * @property \Illuminate\Support\Carbon $parking_end_time
 * @property string $parking_spot
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Invoice $invoice
 */
class ParkingService extends Model
{
    use HasFactory;

    protected $fillable = [
        'parking_id',
        'license_plate',
        'model',
        'color',
        'parking_start_time',
        'parking_end_time',
        'parking_spot',
    ];

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
