<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');


//Route::get('admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
  //  ->middleware('auth')
    //->name('admin.dashboard');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
