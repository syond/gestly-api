<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('api/v1')->middleware('api')->group(function () {
    Route::get('/users', [UserController::class, 'list']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::post('/users', [UserController::class, 'create']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
});

Route::prefix('api/v2')->middleware('api')->group(function () {
    Route::get('/users', [UserController::class, 'list']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::post('/users', [UserController::class, 'create']);
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
