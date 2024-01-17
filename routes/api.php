<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Results routes
Route::prefix('results')->middleware('api')
    ->group(function () {
    Route::get('/{email?}', 'ResultApiController@top')
        ->middleware('api')
        ->name('api.result.top')
        ->where('email', '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}');

    Route::post('/', 'ResultApiController@store')
        ->name('api.result.store');
});
