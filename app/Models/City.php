<?php

namespace App\Models;

use App\Models\Parking;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'latitude',
        'longitude',
    ];

    public function parkings()
    {
        return $this->hasMany(Parking::class);
    }
}
