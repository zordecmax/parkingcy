<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParkingSchedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parking_id',
        'mo_time_start',
        'mo_time_end',
        'mo_break_start',
        'mo_break_end',
        'tu_time_start',
        'tu_time_end',
        'tu_break_start',
        'tu_break_end',
        'we_time_start',
        'we_time_end',
        'we_break_start',
        'we_break_end',
        'th_time_start',
        'th_time_end',
        'th_break_start',
        'th_break_end',
        'fr_time_start',
        'fr_time_end',
        'fr_break_start',
        'fr_break_end',
        'sa_time_start',
        'sa_time_end',
        'sa_break_start',
        'sa_break_end',
        'su_time_start',
        'su_time_end',
        'su_break_start',
        'su_break_end',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'mo_time_start' => 'datetime:H:i',
        'mo_time_end' => 'datetime:H:i',
        'mo_break_start' => 'datetime:H:i',
        'mo_break_end' => 'datetime:H:i',
        'tu_time_start' => 'datetime:H:i',
        'tu_time_end' => 'datetime:H:i',
        'tu_break_start' => 'datetime:H:i',
        'tu_break_end' => 'datetime:H:i',
        'we_time_start' => 'datetime:H:i',
        'we_time_end' => 'datetime:H:i',
        'we_break_start' => 'datetime:H:i',
        'we_break_end' => 'datetime:H:i',
        'th_time_start' => 'datetime:H:i',
        'th_time_end' => 'datetime:H:i',
        'th_break_start' => 'datetime:H:i',
        'th_break_end' => 'datetime:H:i',
        'fr_time_start' => 'datetime:H:i',
        'fr_time_end' => 'datetime:H:i',
        'fr_break_start' => 'datetime:H:i',
        'fr_break_end' => 'datetime:H:i',
        'sa_time_start' => 'datetime:H:i',
        'sa_time_end' => 'datetime:H:i',
        'sa_break_start' => 'datetime:H:i',
        'sa_break_end' => 'datetime:H:i',
        'su_time_start' => 'datetime:H:i',
        'su_time_end' => 'datetime:H:i',
        'su_break_start' => 'datetime:H:i',
        'su_break_end' => 'datetime:H:i',
    ];


    /**
     * Get the parking that owns the schedule.
     */
    public function parking()
    {
        return $this->belongsTo(Parking::class);
    }
}
