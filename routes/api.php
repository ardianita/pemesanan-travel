<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\PemesananController;
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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    // Route::get('/user', [AuthController::class, 'userProfile']);
    Route::prefix('jadwal')->controller(JadwalController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{jadwal}', 'show');
        Route::post('/store', 'store');
        Route::put('/{jadwal}/update', 'update');
        Route::delete('/{jadwal}/delete', 'destroy');
    });
    Route::prefix('pemesanan')->controller(PemesananController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{pemesanan}', 'show');
        Route::post('/store', 'store');
        Route::put('/{pemesanan}/update', 'update');
        Route::delete('/{pemesanan}/delete', 'destroy');
    });
});
