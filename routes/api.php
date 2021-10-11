<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1/users')->group(function () {
    //users
    Route::get('messages', [ChatController::class, 'fetch_message']);
    Route::post('messages', [ChatController::class, 'send_message']);
});

Route::prefix('v1/admin')->group(function () {
    //login
    Route::post('login', [AdminController::class, 'login']);

    //CRUD Users
    Route::get('users', [AdminController::class, 'get_users']);
    Route::post('users', [AdminController::class, 'create_users']);
    Route::put('users/{index}', [AdminController::class, 'update_users']);
    Route::delete('users/{index}', [AdminController::class, 'delete_users']);
    Route::post('users_import', [AdminController::class, 'import_users']);
    //CRUD wof
    Route::get('wof', [AdminController::class, 'get_wof']);
    Route::post('wof', [AdminController::class, 'create_wof']);
    Route::put('wof/{index}', [AdminController::class, 'update_wof']);
    Route::delete('wof/{index}', [AdminController::class, 'delete_wof']);
    Route::post('wof_import', [AdminController::class, 'import_wof']);
    //CRUD Video Url
    Route::get('video', [AdminController::class, 'get_videourl']);
    Route::post('video', [AdminController::class, 'create_videourl']);
    Route::put('video/{index}', [AdminController::class, 'update_videourl']);
    Route::delete('video/{index}', [AdminController::class, 'delete_videourl']);
    Route::post('video_import', [AdminController::class, 'import_videourl']);
    //CRUD sponsor
    Route::get('sponsor', [AdminController::class, 'get_sponsor']);
    Route::post('sponsor', [AdminController::class, 'create_sponsor']);
    Route::put('sponsor/{index}', [AdminController::class, 'update_sponsor']);
    Route::delete('sponsor/{index}', [AdminController::class, 'delete_sponsor']);
    Route::post('sponsor_import', [AdminController::class, 'import_sponsor']);
    //CRUD E-Commerece
    Route::get('bazzar', [AdminController::class, 'get_bazzar']);
    Route::post('bazzar', [AdminController::class, 'create_bazzar']);
    Route::put('bazzar/{index}', [AdminController::class, 'update_bazzar']);
    Route::delete('bazzar/{index}', [AdminController::class, 'delete_bazzar']);
    Route::post('bazzar_import', [AdminController::class, 'import_bazzar']);
});
