<?php

namespace App\Models;

use App\Models\Parking;
use App\Enums\ReservationStatusesEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'airport_id',
        'parking_id',
        'client_id',
        'time_start',
        'time_end',
        'price',
        'status',
    ];

    protected $casts = [
        'status' => ReservationStatusesEnum::class
    ];

    public function parking()
    {
        return $this->belongsTo(Parking::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
