<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\LogController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sensor-readings', [SensorController::class, 'store']);
Route::get('/sensor-readings', [SensorController::class, 'index']);
Route::get('/sensor-readings/latest', [SensorController::class, 'latest']);

Route::post('/commands', [CommandController::class, 'store']);
Route::get('/commands/pending', [CommandController::class, 'pending']);
Route::patch('/commands/{id}/acknowledge',[CommandController::class, 'acknowledge']);
Route::get('/commands/history', [CommandController::class, 'history']);
Route::get('/commands/schema', [CommandController::class, 'schema']);
Route::get('/logs', [LogController::class, 'index']);
Route::get('/sensor-readings/today', [SensorController::class, 'today']);