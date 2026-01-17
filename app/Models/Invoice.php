<?php

namespace App\Models;

use App\Enums\PaymentEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'parking_service_id',
        'invoice_id_hash',
        'amount',
        'created_at',
        'paid',
        'payment_link',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'paid' => PaymentEnum::class,
    ];

    public function parking_service()
    {
        return $this->belongsTo(ParkingService::class);
    }

    public function generate_invoice_id_hash()
    {
        $salt = config('app.salt');
        $pepper = config('app.pepper');

        return hash('sha256', $salt . $this->id . $pepper);
    }

    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($invoice) {
    //         $invoice->invoice_id_hash = $invoice->generate_invoice_id_hash();
    //     });
    // }
}
