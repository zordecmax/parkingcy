<?php

namespace App\Models;

use App\Models\User;
use App\Models\Reservation;
use App\Models\ParkingService;
use App\Models\LongRangeParkingPrice;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parking extends Model
{
    use HasFactory, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'manager_id',
        'name',
        'description',
        'parking_type_id',
        'latitude',
        'longitude',
        'is_long_range',
        'address',
        'phone',
        'total_spaces',
        'available_spaces',
        'handicap_accessible',
        'electric_charging_stations',
        'can_pay_by_card',
        'charging_speed',
        'price_per_hour',
        'price_per_day',
        'max_vehicle_height',
        'active',
        'link',
        'tariff',
        'meta_keywords',
        'meta_description',
        'meta_title',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'electric_charging_stations' => 'integer',
        'can_pay_by_card' => 'boolean',
        'charging_speed' => 'integer',
        'price_per_hour' => 'float',
        'price_per_day' => 'float',
        'max_vehicle_height' => 'float',
        'tariff' => 'array',
        'active' => 'boolean',
    ];

    public function connectorTypes()
    {
        return $this->belongsToMany(ConnectorType::class, 'parking_connector', 'parking_id', 'connector_type_id');
    }

    public function schedule()
    {
        return $this->hasOne(ParkingSchedule::class);
    }

    public function parking_services()
    {
        return $this->hasMany(ParkingService::class);
    }

    public function reports()
    {
        return $this->hasMany(ParkingReport::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function long_range_parking_prices()
    {
        return $this->hasMany(LongRangeParkingPrice::class);
    }
    public function airport()
    {
        return $this->belongsTo(Airport::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
