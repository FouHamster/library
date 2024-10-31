<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\GenerController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminChecker;
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
    Route::post('logout', [UserController::class, 'logout'])->middleware(AuthChecker::class);
    Route::get('me', [UserController::class, 'me'])->middleware(AuthChecker::class);
    Route::post('register', [UserController::class, 'register']);
    Route::post('edit', [UserController::class, 'edit'])->middleware(AuthChecker::class);
});

Route::group([
    'prefix' => 'book'
], function ($router) {
    Route::get('/', [BookController::class, 'index']);
    Route::get('read', [BookController::class, 'read'])->middleware(AuthChecker::class);
    Route::get('download', [BookController::class, 'download'])->middleware(AuthChecker::class);
});

Route::group([
    'prefix' => 'collection'
], function ($router) {
    Route::get('/', [CollectionController::class, 'index'])->middleware(AuthChecker::class);
    Route::post('create', [CollectionController::class, 'create'])->middleware(AuthChecker::class);
    Route::post('add-book', [CollectionController::class, 'addBook'])->middleware(AuthChecker::class);
    Route::get('view', [CollectionController::class, 'view'])->middleware(AuthChecker::class);
});

Route::group([
    'prefix' => 'rent'
], function ($router) {

    Route::get('my', [RentController::class, 'my'])->middleware(AuthChecker::class);
    Route::post('add', [RentController::class, 'add'])->middleware(AuthChecker::class);
});

Route::group([
    'prefix' => 'admin'
], function ($router) {
    Route::get('rent', [RentController::class, 'index'])->middleware(AdminChecker::class);
    Route::get('users', [UserController::class, 'users'])->middleware(AdminChecker::class);
    Route::post('users/update', [UserController::class, 'update'])->middleware(AdminChecker::class);
    Route::get('authors', [AuthorController::class, 'index'])->middleware(AdminChecker::class);
    Route::post('authors/add', [AuthorController::class, 'add'])->middleware(AdminChecker::class);
    Route::post('authors/edit', [AuthorController::class, 'edit'])->middleware(AdminChecker::class);
    Route::get('geners', [GenerController::class, 'index'])->middleware(AdminChecker::class);
    Route::post('geners/add', [GenerController::class, 'add'])->middleware(AdminChecker::class);
    Route::post('geners/edit', [GenerController::class, 'edit'])->middleware(AdminChecker::class);
    Route::post('book/add', [BookController::class, 'add'])->middleware(AdminChecker::class);
    Route::post('book/edit', [BookController::class, 'edit'])->middleware(AdminChecker::class);
});
