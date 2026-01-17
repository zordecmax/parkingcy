<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $user = auth()->user();
            $parking = $user->parking;

            if (!$parking) {
                return;
            }

            $event->menu->add(
                [
                    'text' => 'Setting Parking',
                    'icon' => 'fas fa-fw fa-cog',
                    'url' => route('parkings.edit', $parking),
                ],
                [
                    'text' => 'Reservation Parking',
                    'icon' => 'fas fa-fw fa-calendar',
                    'url' => route('parkings.reservations', $parking),
                ],
                [
                    'text' => 'Manage Parking',
                    'icon' => 'fas fa-fw fa-car',
                    'url' => route('parkings.parking', $parking),
                ],
            );
        });
    }
}
