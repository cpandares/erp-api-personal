<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\CustomSanctumAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

Route::get('/user', [AuthController::class, 'getUser'])->middleware(CustomSanctumAuth::class);