<?php

use App\Http\Controllers\MechanicalControler;
use App\Http\Controllers\PartController;
use App\Http\Controllers\PartStokController;
use App\Http\Controllers\RerportController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);
Route::middleware('verified')->group(function () {
    //dashboard
    Route::get('/home', 'HomeController@index')->name('home');
    //part
    Route::get('/part', [PartController::class, 'index'])->name('part');
    Route::post('/part/store', [PartController::class, 'store'])->name('part.store');
    Route::put('/part/update/{id}', [PartController::class, 'update'])->name('part.update');
    Route::delete('/part/destroy/{id}', [PartController::class, 'destroy'])->name('part.destroy');
    //stok part
    Route::get('/part_stok', [PartStokController::class, 'index'])->name('part_stok');
    Route::post('/part_stok/store', [PartStokController::class, 'store'])->name('part_stok.store');
    Route::put('/part_stok/update/{id}', [PartStokController::class, 'update'])->name('part_stok.update');
    Route::delete('/part_stok/destroy/{id}', [PartStokController::class, 'destroy'])->name('part_stok.destroy');
    //mechanical
    Route::get('/mechanical', [MechanicalControler::class, 'index'])->name('mechanical');
    Route::post('/mechanical/store', [MechanicalControler::class, 'store'])->name('mechanical.store');
    Route::put('/mechanical/update/{id}', [MechanicalControler::class, 'update'])->name('mechanical.update');
    Route::delete('/mechanical/destroy/{id}', [MechanicalControler::class, 'destroy'])->name('mechanical.destroy');
    //laporan
    Route::get('/report/part', [RerportController::class, 'part'])->name('report.part');
    Route::get('/report/service', [RerportController::class, 'services'])->name('report.service');

    //profile
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');

    Route::get('/about', function () {
        return view('about');
    })->name('about');
});
