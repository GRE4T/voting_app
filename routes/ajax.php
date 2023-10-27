<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VotingBoothController;
use App\Http\Controllers\Api\PartyController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RecordController;

/*
|--------------------------------------------------------------------------
| API Routes AJAX
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api local ajax" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth')->group(function (){
    Route::get('/voting-booths', [VotingBoothController::class, 'index']);
    Route::delete('/voting-booths/{votingBooth}', [VotingBoothController::class, 'destroy']);

    Route::get('/parties', [PartyController::class, 'index']);
    Route::delete('/parties/{party}', [PartyController::class, 'destroy']);

    Route::get('/records', [RecordController::class, 'index']);
    Route::delete('/records/{record}', [RecordController::class, 'destroy']);


    Route::get('/users', [UserController::class, 'index']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::put('/users/{user}/change-state', [UserController::class, 'changeStatus']);
});
