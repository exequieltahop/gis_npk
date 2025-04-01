<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataInputController;

// dashboard
Route::get('/', function () { return view('pages.dashboard'); })
    ->name('dashboard');

// data input restrict to admin only
Route::get('/data-input', [DataInputController::class, 'view_data_input'])
    ->name('data-input')
    ->middleware('auth_checker');

Route::post('/sign-in', [DataInputController::class, 'sign_in'])->name('sign-in');
Route::get('/logout', [DataInputController::class, 'logout'])->name('logout');
