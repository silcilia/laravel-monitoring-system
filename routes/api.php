<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\Api\ContactApiController;
use App\Http\Controllers\Api\PowerApiController;
use App\Http\Controllers\Api\MonitoringApiController;
use App\Http\Controllers\Api\DeviceApiController;

Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/logout', [AuthApiController::class, 'logout']);

Route::get('/dashboard', [DashboardApiController::class, 'index']);

Route::get('/services', [ServiceApiController::class, 'index']);
Route::post('/services', [ServiceApiController::class, 'store']);
Route::get('/services/{id}', [ServiceApiController::class, 'show']);
Route::put('/services/{id}', [ServiceApiController::class, 'update']);
Route::delete('/services/{id}', [ServiceApiController::class, 'destroy']);

Route::post('/services/{id}/check', [ServiceApiController::class, 'manualCheck']);
Route::get('/services/{id}/logs', [ServiceApiController::class, 'logs']);

Route::get('/contacts', [ContactApiController::class, 'index']);
Route::post('/contacts', [ContactApiController::class, 'store']);
Route::put('/contacts/{id}', [ContactApiController::class, 'update']);
Route::delete('/contacts/{id}', [ContactApiController::class, 'destroy']);

Route::get('/monitoring-logs', [MonitoringApiController::class, 'index']);
Route::get('/monitoring-logs/{id}', [MonitoringApiController::class, 'show']);

Route::get('/power-data', [PowerApiController::class, 'index']);
Route::post('/power-add', [PowerApiController::class, 'store']);

Route::get('/devices', [DeviceApiController::class, 'index']);

Route::post('/monitoring/start', [MonitoringApiController::class, 'start']);
Route::get('/monitoring/status', [MonitoringApiController::class, 'status']);