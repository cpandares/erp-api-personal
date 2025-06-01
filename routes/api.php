<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnterpriseTypeController;
use App\Http\Middleware\CustomSanctumAuth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

Route::get('/bancos-saldo', [\App\Http\Controllers\BancosSaldoController::class, 'index']);
Route::patch('/bancos-saldo', [\App\Http\Controllers\BancosSaldoController::class, 'update']);

/* group all routes with middleware sanctum */
Route::group(['middleware' => [CustomSanctumAuth::class]], function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::get('/renewToken', [AuthController::class, 'renewToken']);
    Route::get('/types-enterprises', [EnterpriseTypeController::class, 'index']);
    Route::post('/types-enterprises', [EnterpriseTypeController::class, 'store']);
    Route::patch('/types-enterprises/{id}', [EnterpriseTypeController::class, 'update']);
    Route::delete('/types-enterprises/{id}', [EnterpriseTypeController::class, 'destroy']);
    Route::get('/types-enterprises/{param}', [EnterpriseTypeController::class, 'show']);


    Route::get('/taxes', [\App\Http\Controllers\TaxesController::class, 'index']);
    Route::post('/taxes', [\App\Http\Controllers\TaxesController::class, 'store']);
    Route::get('/taxes/{id}', [\App\Http\Controllers\TaxesController::class, 'show']);
    Route::patch('/taxes/{id}', [\App\Http\Controllers\TaxesController::class, 'update']);
    Route::delete('/taxes/{id}', [\App\Http\Controllers\TaxesController::class, 'destroy']);


});
