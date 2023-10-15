<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\frontController;
use App\Http\Controllers\MechanicalControler;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\PartStokController;
use App\Http\Controllers\RerportController;
use App\Http\Controllers\ReviewRatingController;
use App\Http\Controllers\ServiceController;
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


Route::get('/', [frontController::class, 'index']);
Route::get('/search', [frontController::class, 'search'])->name('search');
Route::get('/status', [frontController::class, 'status'])->name('status');
Route::post('/storeServiceOut', [frontController::class, 'storeServiceOut'])->name('storeServiceOut');
Route::post('/storeServiceIn', [frontController::class, 'storeServiceIn'])->name('storeServiceIn');
// route transaction 
Route::post('/add_cart', [frontController::class, 'add_cart'])->name('add_cart');
Route::delete('/destroyCart/{id}', [frontController::class, 'destroyCart'])->name('destroyCart');
Route::post('/add_order', [frontController::class, 'add_order'])->name('add_order');

Auth::routes(['verify' => true]);
Route::middleware('verified')->group(function () {
    //dashboard
    Route::get('/home', 'HomeController@index')->name('home');
    Route::middleware(['role:admin'])->group(function () {
        //ulasan
        Route::get('/rating', [ReviewRatingController::class, 'index'])->name('rating');
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
        //bank
        Route::get('/bank', [BankController::class, 'index'])->name('bank');
        Route::post('/bank/store', [BankController::class, 'store'])->name('bank.store');
        Route::put('/bank/update/{id}', [BankController::class, 'update'])->name('bank.update');
        Route::delete('/bank/destroy/{id}', [BankController::class, 'destroy'])->name('bank.destroy');

        //service
        Route::get('/service/payment', [ServiceController::class, 'payment'])->name('service.payment');
        Route::get('/service/process', [ServiceController::class, 'process'])->name('service.process');
        Route::post('/service/storeMechanical', [ServiceController::class, 'storeMechanical'])->name('service.storeMechanical');
        // Route::post('/service/storeStatus', [ServiceController::class, 'storeStatus'])->name('service.storeStatus');
        Route::post('/service/storePart', [ServiceController::class, 'storePart'])->name('service.storePart');
        Route::post('/service/storePrice', [ServiceController::class, 'storePrice'])->name('service.storePrice');
        Route::put('/service/verified_complite/{id}', [ServiceController::class, 'verified_complite'])->name('service.verified_complite');
        Route::put('/service/verified_reject/{id}', [ServiceController::class, 'verified_reject'])->name('service.verified_reject');
        Route::delete('/service/destroyPrice/{id}', [ServiceController::class, 'destroyPrice'])->name('service.destroyPrice');
        Route::delete('/service/destroyPart/{id}', [ServiceController::class, 'destroyPart'])->name('service.destroyPart');
        Route::delete('/service/destroyMechanic/{id}', [ServiceController::class, 'destroyMechanic'])->name('service.destroyMechanic');
        Route::delete('/service/destroyStatus/{id}', [ServiceController::class, 'destroyStatus'])->name('service.destroyStatus');
        Route::get('/service/invoice/{id}', [ServiceController::class, 'invoice'])->name('service.invoice');
        // Route::get('/service/show/{id}', [ServiceController::class, 'show'])->name('service.show');
        Route::get('/service/non_member', [ServiceController::class, 'non_member'])->name('service.non_member');
        Route::put('/service/accept/{id}', [ServiceController::class, 'accept'])->name('service.accept');
    });
    Route::middleware(['role:admin,owner'])->group(function () {
        //laporan
        Route::get('/report/part', [RerportController::class, 'part'])->name('report.part');
        Route::get('/report/service', [RerportController::class, 'services'])->name('report.service');
    });
    Route::middleware(['role:admin,customer'])->group(function () {

        Route::post('/service/storeStatus', [ServiceController::class, 'storeStatus'])->name('service.storeStatus');
        Route::get('/service/member', [ServiceController::class, 'member'])->name('service.member');
        Route::get('/service/show/{id}', [ServiceController::class, 'show'])->name('service.show');

        //route order
        Route::get('/order', [OrderController::class, 'index'])->name('order');
        Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
        Route::put('/order/update/{id}', [OrderController::class, 'update'])->name('order.update');
        Route::delete('/order/destroy/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
    });
    Route::middleware(['role:customer'])->group(function () {
        Route::post('/rating/store', [ReviewRatingController::class, 'store'])->name('rating.store');
    });
    //profile
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');
});
