<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Doctor\Order\MasterController;
use App\Http\Controllers\IpdNewCaseController;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Ward;
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

Route::get('/users', function () {
    return UserResource::collection(User::all());
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/diet', [App\Http\Controllers\Api\DietController::class, 'index']);
Route::post('/order-master', [MasterController::class, 'store']);

Route::post('login', [App\Http\Controllers\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\LoginController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('wards', [App\Http\Controllers\Api\WardController::class, 'index']);
    Route::get('rooms/{id}', [App\Http\Controllers\Api\RoomController::class, 'index']);
    Route::get('bed/{id}', [App\Http\Controllers\Api\BedController::class, 'show']);
    Route::get('ipd/{id}', [App\Http\Controllers\Api\IpdController::class, 'index']);
    Route::post('profile', [App\Http\Controllers\LoginController::class, 'profile']);
    Route::get('/logged-in-user', [UserController::class, 'loggedInUser']);
});

Route::post('/ipd/newcase', [IpdNewCaseController::class, 'store']);
