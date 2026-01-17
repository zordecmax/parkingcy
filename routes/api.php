<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\AirportController;
use App\Http\Controllers\Api\ParkingController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\ParkingReportController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\ConnectorTypeController;
use App\Http\Controllers\Api\ParkingAnalyticsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/reviews/{parking:id}', [ReviewController::class, 'index'])->name('api.reviews.index');
Route::post('/reviews/{parking:id}', [ReviewController::class, 'store'])->name('api.reviews.store');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/connector-types', [ConnectorTypeController::class, 'index'])->name('api.connector-types.index');
Route::post('/parkings', [ParkingController::class, 'index'])->name('api.parkings.index');

Route::get('/parkings/filter', [ParkingController::class, 'filter'])->name('api.parkings.filter');

Route::post('/parkings/{parking:id}/payment', [PaymentController::class, 'store'])->name('api.parkings.payment.store');

Route::middleware('throttle:1,1')->group(function () {
    Route::post('/parking-reports', [ParkingReportController::class, 'store'])->name('api.parking-reports.store');
});

Route::get('/parkings/{parking:id}/reports', [ParkingReportController::class, 'showLastParkingReport'])->name('api.parkings.reports.show');

Route::get('/airports', [AirportController::class, 'index'])->name('airports.index');
Route::get('/cities', [CityController::class, 'index'])->name('api.cities.index');

Route::put('/reservations/{reservation:id}/status', [ReservationController::class, 'updateStatus'])->name('api.reservations.status.update');

Route::middleware('throttle:10,1')->group(function () {
    Route::get('/debug/google-traffic', [ParkingAnalyticsController::class, 'googleTrafficByCoords'])
        ->name('api.debug.google-traffic');

    Route::get('/debug/parkings/{parking:id}/google-traffic', [ParkingAnalyticsController::class, 'googleTraffic'])
        ->name('api.debug.parkings.google-traffic');
});
