<?php

namespace App\Models;

use App\Models\User;
use App\Models\Parking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



/**
 * App\Models\ParkingReport
 *
 * @property int $id
 * @property int $parking_id
 * @property bool $is_space_available
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Parking $parking
 */
class ParkingReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parking_id',
        'is_space_available',
        'comment',
    ];

    protected $casts = [
        'is_space_available' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function parking()
    {
        return $this->belongsTo(Parking::class);
    }
}
