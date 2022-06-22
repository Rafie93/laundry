<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegionsController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\AccountController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\Information\NewsController;
use App\Http\Controllers\Api\GetIPCityController;
use App\Http\Controllers\Api\Subscription\PackageController;
use App\Http\Controllers\Api\Outlet\OutletController;
use App\Http\Controllers\Api\Outlet\CustomerController;

use App\Http\Controllers\Api\Master\SatuanController;
use App\Http\Controllers\Api\Master\CategoryController;
use App\Http\Controllers\Api\Master\BarangController;
use App\Http\Controllers\Api\Master\ParfumeController;
use App\Http\Controllers\Api\Master\ServiceController;
use App\Http\Controllers\Api\Master\RakController;
use App\Http\Controllers\Api\Subscription\SubscribeController;
use App\Http\Controllers\Api\Expenditure\ExpenditureCategoryController;
use App\Http\Controllers\Api\Expenditure\ExpenditureController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Pegawai\PegawaiController;
use App\Http\Controllers\Api\Dashboard\DashboardController;


Route::group(['prefix' => 'v1','namespace' => 'Api', 'as' => 'api.'], function() {

    Route::get('location', [GetIPCityController::class, 'index']);
    Route::get('states', [RegionsController::class, 'provinces'])->name('regions.states');
    Route::get('cities', [RegionsController::class, 'cities'])->name('regions.cities');
    Route::get('city', [RegionsController::class, 'city'])->name('regions.city');
    Route::get('districts', [RegionsController::class, 'districts'])->name('regions.districts');

    Route::post('login', [LoginController::class,'login'])->name('login');
    Route::post('register', [RegisterController::class,'register'])->name('register');

    Route::get('slider', [SliderController::class,'index']);
    Route::get('news', [NewsController::class,'index']);

    Route::get('package', [PackageController::class,'index']);

    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('dashboard', [DashboardController::class,'index']);

        Route::get('method', [MethodController::class,'index']);
        Route::post('subscribe/store', [SubscribeController::class,'store']);
        Route::get('subscribe/history', [SubscribeController::class,'history']);

        Route::get('account', [AccountController::class,'index']);
        Route::get('account/myoutlet', [AccountController::class,'myoutlet']);

        Route::post('account/change', [AccountController::class,'changeProfile']);
        Route::post('change_password', [AccountController::class,'updatepassword']);
        Route::post('account/switch_outlet/{id}', [AccountController::class,'switch_outlet']);

        Route::get('outlet', [OutletController::class,'index']);
        Route::post('outlet/store', [OutletController::class,'store']);
        Route::post('outlet/update/{id}', [OutletController::class,'update']);

        Route::get('customer', [CustomerController::class,'index']);
        Route::post('customer/store', [CustomerController::class,'store']);
        Route::post('customer/update/{id}', [CustomerController::class,'update']);
        Route::get('customer/delete/{id}', [CustomerController::class,'delete']);

        Route::get('satuan', [SatuanController::class,'index']);
        Route::post('satuan/store', [SatuanController::class,'store']);
        Route::post('satuan/update/{id}', [SatuanController::class,'update']);
        Route::get('satuan/delete/{id}', [SatuanController::class,'delete']);

        Route::get('rak', [RakController::class,'index']);
        Route::post('rak/store', [RakController::class,'store']);
        Route::post('rak/update/{id}', [RakController::class,'update']);
        Route::get('rak/delete/{id}', [RakController::class,'delete']);


        Route::get('category', [CategoryController::class,'index']);
        Route::post('category/store', [CategoryController::class,'store']);
        Route::post('category/update/{id}', [CategoryController::class,'update']);
        Route::get('category/delete/{id}', [CategoryController::class,'delete']);

        Route::get('barang', [BarangController::class,'index']);
        Route::post('barang/store', [BarangController::class,'store']);
        Route::post('barang/update/{id}', [BarangController::class,'update']);
        Route::get('barang/delete/{id}', [BarangController::class,'delete']);

        Route::get('service', [ServiceController::class,'index']);
        Route::post('service/store', [ServiceController::class,'store']);
        Route::post('service/update/{id}', [ServiceController::class,'update']);
        Route::get('service/delete/{id}', [ServiceController::class,'delete']);

        Route::get('parfume', [ParfumeController::class,'index']);
        Route::post('parfume/store', [ParfumeController::class,'store']);
        Route::post('parfume/update/{id}', [ParfumeController::class,'update']);
        Route::get('parfume/delete/{id}', [ParfumeController::class,'delete']);

        Route::get('pengeluaran/category', [ExpenditureCategoryController::class,'index']);
        Route::post('pengeluaran/category/store', [ExpenditureCategoryController::class,'store']);
        Route::post('pengeluaran/category/update/{id}', [ExpenditureCategoryController::class,'update']);
        Route::get('pengeluaran/category/delete/{id}', [ExpenditureCategoryController::class,'delete']);

        Route::get('pengeluaran', [ExpenditureController::class,'index']);
        Route::post('pengeluaran/store', [ExpenditureController::class,'store']);
        Route::post('pengeluaran/update/{id}', [ExpenditureController::class,'update']);
        Route::get('pengeluaran/delete/{id}', [ExpenditureController::class,'delete']);

        Route::get('order', [OrderController::class,'index']);
        Route::get('order/detail/{id}', [OrderController::class,'detail']);
        Route::post('order/store', [OrderController::class,'store']);
        Route::post('order/update_status_order/{id}', [OrderController::class,'update_status_order']);

        Route::get('pegawai', [PegawaiController::class,'index']);
        Route::post('pegawai/store', [PegawaiController::class,'store']);
        Route::post('pegawai/update/{id}', [PegawaiController::class,'update']);
        Route::get('pegawai/delete/{id}', [PegawaiController::class,'delete']);

      
    });
});