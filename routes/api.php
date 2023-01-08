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
*/

Route::namespace('App\\Http\\Controllers')->group(function () {
    //UsersController
    Route::controller(UsersController::class)->group(function () {
        Route::post('/users', 'store');
        Route::delete('/delete/{id}', 'delete');
        Route::put('/update', 'update');
    });
    //SubjectsController
    Route::controller(SubjectsController::class)->group(function () {
        Route::get('/subjects', 'index');
        Route::post('/subjects', 'store');
        Route::put('/subjects', 'update');
        Route::delete('/subjects/{id}', 'delete');
    });
    //SubjectUserController
    Route::controller(SubjectUserController::class)->group(function () {
        Route::post('/asignar', 'store');
        Route::put('/asignar', 'update');
        Route::get('/asignar', 'index');
    });

    Route::controller(CreditsController::class)->group(function () {
        Route::get('/credit/{id}', 'index');
        Route::post('/credit', 'store');
    });
});
