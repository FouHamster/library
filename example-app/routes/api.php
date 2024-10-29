<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => 'user'
], function ($router) {
    Route::post('login', [UserController::class, 'login']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('me', [UserController::class, 'me']);
    Route::post('register', [UserController::class, 'register']);
    Route::post('edit', [UserController::class, 'edit'])->middleware(AuthChecker::class);
});

Route::group([
    'prefix' => 'book'
], function ($router) {
    Route::get('/', [BookController::class, 'index']);
});

Route::group([
    'prefix' => 'collection'
], function ($router) {
    Route::get('/', [CollectionController::class, 'index'])->middleware(AuthChecker::class);
    Route::post('create', [CollectionController::class, 'create'])->middleware(AuthChecker::class);
});
