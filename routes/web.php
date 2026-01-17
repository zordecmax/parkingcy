<?php

use App\Models\Parking;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Services\Parking\ParkingService;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\ManageParkingController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SearchController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        // 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::get('/', function () {
            return response(view('welcome'))->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        })->name('home');
        Route::get('/parkings/airport/{airport:slug}', [AirportController::class, 'show'])->name('parkings.airport.show');
        Route::get('/parkings/airport/{airport:slug}/search', [SearchController::class, 'index'])->name('parkings.airport.search.index');
        Route::post('/parkings/airport/{airport:slug}/search', [SearchController::class, 'store'])->name('parkings.airport.search.store');
        Route::get('/map/{city:slug}', [MapController::class, 'city'])->name('map.cities.show');
        Route::get('/map/{city:slug}/{parking:slug}', [MapController::class, 'parking'])->name('map.parkings.show');


        // Route::get('/city/{city:slug}/sector/{sector}/{parking:slug}', [ParkingController::class, 'show'])->name('parkings.show'); //TODO обрабатывать руты
        // Route::get('/map/{parking:id}', [ParkingController::class, 'show'])->name('parkings.showId');   //TODO обрабатывать руты
        Route::get('/map/{parking:id}', fn () => view('welcome'))->name('parkings.showId');   //TODO обрабатывать руты

        Route::group(['prefix' => 'payment'], function () {
            Route::get('success/{invoice:invoice_id_hash}', [PaymentController::class, 'success'])->name('payment.success');
            Route::get('failure', [PaymentController::class, 'failure'])->name('payment.failure');
        });
        Route::get('/contacts', function () {
            return 'Contacts';
        })->name('contacts');

        Route::post('/reservations/airport/{airport:slug}/parking/{parking}', [ReservationController::class, 'store'])->name('reservations.store');
        Route::get('/reservations-success', function () {
            return view('parkings.airports.reservations-success');
        })->name('reservations.success');
        Route::get('/reservations-fail', function () {
            return view('parkings.airports.reservations-fail');
        })->name('reservations.fail');
    }
);

Route::middleware('role:manager')->group(function () {
    Route::group(['prefix' => 'parkings'], function () {
        Route::get('/{parking:id}/payment', [PaymentController::class, 'show'])->name('parkings.payment.show');
        Route::post('/{parking:id}/payment', [PaymentController::class, 'store'])->name('parkings.payment.store');
        Route::get('/{parking:id}/qr', [QRCodeController::class, 'show'])->name('parkings.qr.show');

        Route::get('/{parking:id}/parking', [ParkingController::class, 'parking'])->name('parkings.parking');
        Route::delete('/services/{service}', [ManageParkingController::class, 'destroy'])->name('parkings.services.destroy');
        Route::post('/parkings/{parking}', [ManageParkingController::class, 'store'])->name('parkings.services.store');
        Route::put('/parking_services/{service}/{parking}', [ManageParkingController::class, 'update'])->name('parkings.services.update');

        Route::get('/{parking:id}/reservations', [ParkingController::class, 'reservations'])->name('parkings.reservations');
        Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
        Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    });

    Route::get('/manager/dashboard', [ParkingController::class, 'index'])->name('manager.dashboard');

    Route::resource('parkings', ParkingController::class)->except(['index', 'store']);
})->prefix('admin');


// Route::get('/example', function () {

//     return view('parkings.payments.failure');
// });
// Route::get('/example2', function () {

//     return view('parkings.payments.success');
// });
// Route::get('/card', function () {

//     return view('card');
// });

Route::group(['prefix' => 'adm'], function () {
    Voyager::routes();
});
Auth::routes();
