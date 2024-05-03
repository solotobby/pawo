<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'auth'], function () {
    Route::get('/', function () {
        return view('welcome');
    });


});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('user/home', [\App\Http\Controllers\HomeController::class, 'userHome'])->name('user.home');
    Route::get('admin/home', [\App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home');
});
Auth::routes();


