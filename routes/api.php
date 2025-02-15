<?php

use App\Http\Controllers\Admin\JadwalController;
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

Route::prefix('jadwal')->controller(JadwalController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{jadwal}', 'show');
    Route::post('/store', 'store');
    Route::put('/{jadwal}/update', 'update');
    Route::destroy('/{jadwal}/delete', 'destroy');
});
