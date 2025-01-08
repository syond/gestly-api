<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;



Route::middleware('api')->group(function () {
    Route::get('/users', [UserController::class, 'list']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
});

Route::get('/', function () {
    return view('welcome');
});

// Por enquanto é necessário adicionar ao header do request X-CSRF-TOKEN=...
// para fazer requests que modificam dados
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});
