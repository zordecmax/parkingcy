<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'car_number',
        'car_model',
        'car_color',
        'payment_method',
    ];
}
