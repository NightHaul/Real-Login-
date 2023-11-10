<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::middleware(['guest'])->group(function () {
    // guest、authはもうララベルが用意してくれてる

Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'show_login'])->name('show_login');

    Route::post('/login', [AuthController::class, 'login'])->name('login');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/home', function(){
        return view('login.home');
    })->name('home');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});




