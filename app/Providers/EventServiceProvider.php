<?php

namespace App\Providers;

use App\Events\ParkingServiceCreatedEvent;
use App\Events\PaymentCreatedEvent;
use App\Listeners\CreateParkingServiceListener;
use App\Listeners\CreateInvoiceListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PaymentCreatedEvent::class => [
            CreateParkingServiceListener::class,
        ],
        ParkingServiceCreatedEvent::class => [
            CreateInvoiceListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        // $user = Auth::user();
        // dd($user);
    }
}
