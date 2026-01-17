<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'parking_id',
        'user_id',
        'review',
        'rating',
    ];//to do user_id

    public function parking()
    {
        return $this->belongsTo(Parking::class);
    }
}
