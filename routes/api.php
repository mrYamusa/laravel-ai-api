<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Resources\UserResource;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/users', function (Request $request) {
    $user = UserResource::collection(User::all());
    return $user;
});

Route::get('/hello', function(){
    return ['message' => 'Your first API Response using Laravel'];
});

Route::prefix('v1')->group(function (){
    Route::apiResource('posts', PostController::class);
});

// Route::apiResource('posts', PostController::class);

// Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
// Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
// Route::get('/posts/{id}', [PostController::class, 'show'])->whereNumber('id')->name('posts.show');
