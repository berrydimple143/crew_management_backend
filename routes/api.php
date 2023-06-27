<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\RankController;
use App\Http\Controllers\Api\CrewController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
});

Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::get('list', 'index');
    Route::get('roles', 'roles');
    Route::post('show', 'show');
    Route::post('create', 'create');
    Route::post('edit', 'edit');
    Route::post('update', 'update');
    Route::post('destroy', 'destroy');
});

Route::controller(RankController::class)->prefix('ranks')->group(function () {
    Route::get('list', 'index');
    Route::post('show', 'show');
    Route::post('create', 'create');
    Route::post('edit', 'edit');
    Route::post('update', 'update');
    Route::post('destroy', 'destroy');
});

Route::controller(CrewController::class)->prefix('crews')->group(function () {
    Route::get('list', 'index');
    Route::get('count', 'count');
    Route::post('byRank', 'byRank');
    Route::post('show', 'show');
    Route::post('create', 'create');
    Route::post('edit', 'edit');
    Route::post('update', 'update');
    Route::post('destroy', 'destroy');
});

Route::controller(DocumentController::class)->prefix('documents')->group(function () {
    Route::get('list', 'index');
    Route::get('count', 'count');
    Route::post('show', 'show');
    Route::post('create', 'create');
    Route::post('edit', 'edit');
    Route::post('file-upload', 'fileUpload');
    Route::post('update', 'update');
    Route::post('destroy', 'destroy');
});
