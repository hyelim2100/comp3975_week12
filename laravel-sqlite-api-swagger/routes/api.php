<?php

use App\Http\Controllers\api\StudentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('students', function () {
    return Student::all();
});

// Route::get('students', [StudentsController::class, 'index']);
// Route::get('students/{student}', [StudentsController::class, 'show']);
// Route::post('students', [StudentsController::class, 'store']);
// Route::put('students/{student}', [StudentsController::class, 'update']);
// Route::delete('students/{student}', [StudentsController::class, 'destroy']);

Route::resource('students', StudentsController::class);