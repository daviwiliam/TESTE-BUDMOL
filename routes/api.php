<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserEventController;
use Illuminate\Support\Facades\Route;

//Rotas de autenticação
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Rotas de Eventos
Route::apiResource('events', EventController::class);

//Rotas de participantes e inscrições
Route::get('/my-events/{userId}', [UserEventController::class, 'myEvents']);
Route::get('/participants/{eventId}', [UserEventController::class, 'participants']);
Route::get('/subscriptions/{userId}', [UserEventController::class, 'subscriptions']);
Route::post('/subscribe', [UserEventController::class, 'subscribe']);
Route::put('/cancel-subscription/{eventId}', [UserEventController::class, 'cancelSubscription']);


