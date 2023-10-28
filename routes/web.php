<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\VotingBoothsController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\RecordController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {

        //Navigation base
        Route::get('/', function () {
            return redirect('/records');
        });

        Route::get('/home', function (){
            return redirect('/records');
        })->name('home');

        Route::resource('/voting-booths', VotingBoothsController::class)->except('show');
        Route::resource('/parties', PartyController::class)->except('show');
        Route::get('/records/{record}/report', [RecordController::class, 'report'])->name('records.report');
        Route::resource('/records', RecordController::class)->except('show');


        //Users
        Route::resource('/users', UserController::class)->except('show')->middleware('admin');

        //Route profile
        Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
        Route::put('/user/update-profile', [UserController::class, 'updateProfile'])->name('user.updateProfile');
        Route::post('/user/updatePassword', [UserController::class, 'updatePassword'])->name('user.password');

        //Configuration
        Route::post('/configurations', [ConfigurationController::class, 'store'])->name('configurations.store');

        //Code Status
        Route::view('notAuthorized', 'others.notAuthorized')->name('notAuthorized');

});

// Auth::routes();
Route::get('/login',  [LoginController::class, 'index'])->name('login');
Route::post('/login',  [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout',  [LoginController::class, 'logout'])->name('logout');


//Forgot Password
Route::get('/forgot-password', [PasswordController::class, 'index'])->name('password.forgot');
Route::post('/forgot-password', [PasswordController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordController::class, 'resetPassword'])->name('password.reset');
Route::post('/reset-password', [PasswordController::class, 'passwordUpdate'])->name('password.update');

