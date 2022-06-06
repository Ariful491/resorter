<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Frontend\FrontendController;


Route::get('/',[FrontendController::class,'index'])->name('/');
Route::get('/booking/{id}',[FrontendController::class,'booking'])->name('booking');
Route::post('/booking',[FrontendController::class,'bookingStore'])->name('book.store');

Route::get('/dashboard',[BackendController::class,'index'])->name('dashboard');
Route::resource('resorts',\App\Http\Controllers\Backend\ResortController::class);

