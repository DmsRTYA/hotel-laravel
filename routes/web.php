<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemesananController;

Route::get('/',           [PemesananController::class, 'index']  )->name('pemesanan.index');
Route::post('/tambah',    [PemesananController::class, 'store']  )->name('pemesanan.store');
Route::get('/edit/{id}',  [PemesananController::class, 'edit']   )->name('pemesanan.edit');
Route::put('/update/{id}',[PemesananController::class, 'update'] )->name('pemesanan.update');
Route::delete('/hapus/{id}',[PemesananController::class,'destroy'])->name('pemesanan.destroy');
