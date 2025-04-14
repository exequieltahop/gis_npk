<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataInputController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\BarangayDataController;

// dashboard
Route::get('/', function () { return view('pages.dashboard'); })
    ->name('dashboard');

// data input restrict to admin only
Route::get('/data-input', [DataInputController::class, 'view_data_input'])->name('data-input')->middleware('auth_checker');
    Route::post('/add-data', [DataInputController::class, 'addData'])->name('add-data-input')->middleware('auth_checker');
    Route::put('/edit-data', [DataInputController::class, 'editData'])->name('edit-data-input')->middleware('auth_checker');
    Route::delete('/delete-data-input/{id}', [DataInputController::class, 'deleteData'])->name('delete-data-input')->middleware('auth_checker');
    Route::delete('/data-import', [DataInputController::class, 'dataImport'])->name('data-import')->middleware('auth_checker');


// add brgy
Route::post('/add-brgy', [BarangayController::class, 'addBarangay'])->name('add-brgy')->middleware('auth_checker');
Route::put('/edit-brgy', [BarangayController::class, 'editBarangay'])->name('edit-brgy')->middleware('auth_checker');
Route::delete('/delete-brgy/{id}', [BarangayController::class, 'deleteBarangay'])->name('delete-brgy')->middleware('auth_checker');

// sign in and sign out
Route::post('/sign-in', [AuthController::class, 'sign_in'])->name('sign-in');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/view-brgy-data/{id}', [BarangayDataController::class, 'viewBrgyDataView'])->name('view-brgy-data');
Route::get('/get-brgy-data/{id}', [BarangayDataController::class, 'getBrgyDataView']);
