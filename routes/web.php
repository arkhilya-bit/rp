<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PushController;

Route::get('/', [UserController::class, 'index']);
Route::get('/top', [UserController::class, 'showTopUsers']);

Route::get('/login', fn() => view('users.auth'))->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::middleware(['auth'])->group(function () {
    Route::get('/push', fn() => view('users.push'));
    Route::post('/push/toggle', [PushController::class, 'toggle']);
    Route::get('/push/status', [PushController::class, 'status']);
});

Route::get('/push/send', [PushController::class, 'send']);