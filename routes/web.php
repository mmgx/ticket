<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [SiteController::class, 'home'])->name('home');

Route::group([
    'prefix' => 'shows',
    'as' => 'shows.',
], function () {
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/{showId}/events', [EventController::class, 'show'])->name('show');
});

Route::group([
    'prefix' => 'events',
    'as' => 'events.',
], function () {
    Route::get('/{eventId}/places', [EventController::class, 'places'])->name('places');
});

Route::post('booking', [EventController::class, 'booking'])->name('booking');
