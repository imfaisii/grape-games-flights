<?php

use App\Notifications\ApiNotify;
use App\Services\FlightApiService;
use Illuminate\Support\Facades\Notification;
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

Route::get('/', function () {
    Notification::route('mail', 'cfaisal009@gmail.com')->notify(new ApiNotify("Execution was completed successfully."));

    echo '<p style="text-align: center;color:red;">What you are looking is not here. 404 :(</p>';

    return;
});
