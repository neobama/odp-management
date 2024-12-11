<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OdpController;
use App\Http\Controllers\ClientController;
use App\Models\Odp;

Route::get('/', [OdpController::class, 'summary'])->name('home');


Route::resource('odps', OdpController::class);

// Route untuk menambahkan klien ke ODP
Route::post('odps/{odp}/clients', [ClientController::class, 'store'])->name('clients.store');

// Route untuk melihat klien di ODP
Route::get('odps/{odp}/clients', [ClientController::class, 'index'])->name('clients.index');