<?php

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
*/Route::post('users/auth',[\App\Http\Controllers\UserController::class, 'auth']);
Route::post('users/save',[\App\Http\Controllers\UserController::class, 'create']);

Route::post('image/save',[\App\Http\Controllers\ImageController::class, 'create']);
Route::put('image/edit/{idImage}',[\App\Http\Controllers\ImageController::class, 'edit']);
Route::get('image/show/{idImage}',[\App\Http\Controllers\ImageController::class, 'show']);
Route::get('image/list',[\App\Http\Controllers\ImageController::class, 'list']);
Route::delete('image/deleted/{idImage}',[\App\Http\Controllers\ImageController::class, 'delete']);
