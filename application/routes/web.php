<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostInteractionController;
use App\Http\Controllers\MediaObjectController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormInputController;
use App\Http\Controllers\CategoryController;

Route::prefix('api/v1')->middleware('api')->group(function () {
    Route::get('/users', [UserController::class, 'list']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::post('/users', [UserController::class, 'create']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
    
    Route::get('/users/{userId}/posts', [PostController::class, 'listByUser']);
    
    Route::get('/posts', [PostController::class, 'list']);
    Route::get('/posts/{postId}', [PostController::class, 'show']);
    Route::delete('/posts/{postId}', [PostController::class, 'delete']);
    Route::post('/posts', [PostController::class, 'create']);
    Route::put('/posts/{postId}', [PostController::class, 'update']);
    
    Route::post('/post-interactions', [PostInteractionController::class, 'create']);
    Route::put('/post-interactions/{id}', [PostInteractionController::class, 'update']);
    Route::delete('/post-interactions/{id}', [PostInteractionController::class, 'delete']);

    Route::post('/medias', [MediaObjectController::class, 'create']);
    Route::put('/medias/{id}', [MediaObjectController::class, 'update']);
    Route::get('/medias', [MediaObjectController::class, 'list']);
    Route::get('/medias/{id}', [MediaObjectController::class, 'show']);
    Route::delete('/medias/{id}', [MediaObjectController::class, 'delete']);

    Route::get('/forms', [FormController::class, 'list']);
    Route::get('/forms/{id}', [FormController::class, 'show']);
    Route::put('/forms/{id}', [FormController::class, 'update']);
    Route::post('/forms', [FormController::class, 'create']);
    Route::delete('/forms/{id}', [FormController::class, 'delete']);

    Route::get('/form-inputs', [FormInputController::class, 'list']);
    Route::get('/form-inputs/{id}', [FormInputController::class, 'show']);
    Route::delete('/form-inputs/{id}', [FormInputController::class, 'delete']);
    Route::post('/form-inputs', [FormInputController::class, 'create']);
    Route::put('/form-inputs/{id}', [FormInputController::class, 'update']);

    Route::get('/categories', [CategoryController::class, 'list']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::delete('/categories/{id}', [CategoryController::class, 'delete']);
    Route::post('/categories', [CategoryController::class, 'create']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
});

Route::get('/', function () {
    return view('welcome');
});

// Por enquanto é necessário adicionar ao header do request X-CSRF-TOKEN=...
// para fazer requests que modificam dados
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});
