<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
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

// Public routes
Route::controller(AuthController::class)->group(function(){
    Route::post('auth/login', 'login');
});

// Private routes for HRManager
Route::group(['middleware' => ['auth:sanctum', 'CheckRole']], function () {
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/role/{role}', [UserController::class, 'indexByRole']);
    Route::post('users/deactivate/{id}', [UserController::class, 'deactivate']);
});

// Private routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('users/{id}', [UserController::class, 'show']); 
    Route::put('users/{id}', [UserController::class, 'updateEmployeeContactInfo']);
});
