<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\NoticiaController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/users', [UserController::class, 'store']);
Route::post('/logout/{user}', [UserController::class, 'logout']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::put('/noticias/{noticia}', [NoticiaController::class, 'update']);
    Route::delete('/noticias/{noticia}', [NoticiaController::class, 'destroy']);
    Route::get('/noticias/{noticia}', [NoticiaController::class, 'show']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/noticias', [NoticiaController::class, 'index']);
    Route::post('/noticias', [NoticiaController::class, 'store']);
});



