<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Sistem\UserController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Info\SliderController;
use App\Http\Controllers\Sistem\ProfileController;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\PaymentController;

//
use App\Http\Controllers\Master\SatuanController;
use App\Http\Controllers\Master\LayananController;
use App\Http\Controllers\Master\CategoryController;

Route::get('/firebase',[HomeController::class, 'firebasetest']);

Route::get('unauthorised',[LoginController::class,'unauthorised'])->name('unauthorised');
Route::get('/forgot', [ForgotPasswordController::class, 'index'])->name('forgot');
Route::post('/forgot/check', [ForgotPasswordController::class, 'check'])->name('forgot.check');

Route::post('payments/notification', [PaymentController::class,'notification']);
Route::get('payments/completed', [PaymentController::class,'completed']);
Route::get('payments/failed', [PaymentController::class,'failed']);
Route::get('payments/unfinish', [PaymentController::class,'unfinish']);

Auth::routes();   
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/profile', [ProfileController::class, 'index'])->name('myprofile');
Route::get('/profile/change', [ProfileController::class, 'change'])->name('profile.change');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/resetpassword', [ProfileController::class, 'resetpassword'])->name('profile.password.reset');
Route::post('/profile/password/update', [ProfileController::class, 'updatepassword'])->name('profile.password.update');

Route::get('/users', [UserController::class, 'index'])->name('user');
Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
Route::post('/users/store', [UserController::class, 'store'])->name('user.store');
Route::get('/users/{id}/edit', [userController::class, 'edit'])->name('user.edit');
Route::post('/users/{id}/update', [userController::class, 'update'])->name('user.update');

Route::get('/order/process', [OrderController::class, 'index'])->name('order');
Route::get('/order/history', [OrderController::class, 'history'])->name('order.history');
Route::post('/order/update', [OrderController::class, 'update'])->name('order.update');
Route::get('/order/detail/{id}', [OrderController::class, 'detail'])->name('order.detail');


Route::get('/member', [MemberController::class, 'index'])->name('member');

Route::get('/slider', [SliderController::class, 'index'])->name('slider');
Route::get('/slider/create', [SliderController::class, 'create'])->name('slider.create');
Route::post('/slider/slider', [SliderController::class, 'store'])->name('slider.store');
Route::post('/slider/upload', [SliderController::class, 'upload'])->name('slider.upload');
Route::get('/slider/{id}/delete', [SliderController::class, 'delete']);
Route::get('/slider/{id}/edit', [SliderController::class, 'edit'])->name('slider.edit');
Route::post('/slider/{id}/update', [SliderController::class, 'update'])->name('slider.update');

Route::get('/stores', [StoresController::class, 'index'])->name('stores');
Route::get('/stores/create', [StoresController::class, 'create'])->name('stores.create');
Route::post('/stores/stores', [StoresController::class, 'store'])->name('stores.store');
Route::get('/stores/{id}/edit', [StoresController::class, 'edit'])->name('stores.edit');
Route::post('/stores/{id}/update', [StoresController::class, 'update'])->name('stores.update');

Route::get('/category', [CategoryController::class, 'index'])->name('category');
Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category/stores', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/{id}/delete', [CategoryController::class, 'delete'])->name('category.delete');
Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/{id}/update', [CategoryController::class, 'update'])->name('category.update');

Route::get('/satuan', [SatuanController::class, 'index'])->name('satuan');
Route::get('/satuan/create', [SatuanController::class, 'create'])->name('satuan.create');
Route::post('/satuan/stores', [SatuanController::class, 'store'])->name('satuan.store');
Route::get('/satuan/{id}/delete', [SatuanController::class, 'delete'])->name('satuan.delete');
Route::get('/satuan/{id}/edit', [SatuanController::class, 'edit'])->name('satuan.edit');
Route::post('/satuan/{id}/update', [SatuanController::class, 'update'])->name('satuan.update');

Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
Route::get('/layanan/create', [LayananController::class, 'create'])->name('layanan.create');
Route::post('/layanan/stores', [LayananController::class, 'store'])->name('layanan.store');
Route::get('/layanan/{id}/delete', [LayananController::class, 'delete'])->name('layanan.delete');
Route::get('/layanan/{id}/edit', [LayananController::class, 'edit'])->name('layanan.edit');
Route::post('/layanan/{id}/update', [LayananController::class, 'update'])->name('layanan.update');


Route::post('/save-push-notification-token', [HomeController::class, 'savePushNotificationToken'])->name('save-push-notification-token');
Route::post('/send-push-notification', [HomeController::class, 'sendPushNotification'])->name('send.push-notification');

