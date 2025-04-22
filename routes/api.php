<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnterpriseTypeController;
use App\Http\Middleware\CustomSanctumAuth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);



/* group all routes with middleware sanctum */
Route::group(['middleware' => [CustomSanctumAuth::class]], function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::get('/types-enterprises', [EnterpriseTypeController::class, 'index']);
    Route::post('/types-enterprises', [EnterpriseTypeController::class, 'store']);
    Route::patch('/types-enterprises/{id}', [EnterpriseTypeController::class, 'update']);
    Route::delete('/types-enterprises/{id}', [EnterpriseTypeController::class, 'destroy']);
    Route::get('/types-enterprises/{param}', [EnterpriseTypeController::class, 'show']);
});
