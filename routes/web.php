<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SliderController;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function(){

    Route::get('home', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.home');
    Route::resource('slider', SliderController::class); // CRUD SLIDER
    Route::resource('categories', CategoryController::class); // CRUD CATEGORY

});

