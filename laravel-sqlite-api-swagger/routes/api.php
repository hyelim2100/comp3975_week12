<?php

use App\Http\Controllers\api\PlayersController;
use App\Http\Controllers\api\StudentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('students', StudentsController::class);
Route::resource('players', PlayersController::class);
