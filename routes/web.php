<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
})->name('index');

Route::get('login-page', 'App\Http\Controllers\AuthController@index')->name('login-page');
Route::post('login-page', 'App\Http\Controllers\AuthController@login')->name('login-process');
Route::get('logout', 'App\Http\Controllers\AuthController@logout')->name('logout');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'superadmin', 'middleware' => ['authorized:superadmin']], function () {
        Route::get('/', [SuperAdminController::class, 'index'])->name('superadmin.index');
        //product category route
        Route::get('product-category', [SuperAdminController::class, 'showProductCategory'])->name('product-category');
        Route::get('product-category/{id}', [SuperAdminController::class, 'showDetailProductCategory'])->name('product-category.detail');
        Route::post('product-category', [SuperAdminController::class, 'addProductCategory'])->name('product-category.store');
        Route::put('product-category/{id}', [SuperAdminController::class, 'updateProductCategory'])->name('product-category.update');
        Route::delete('product-category/{id}', [SuperAdminController::class, 'deleteProductCategory'])->name('product-category.destroy');
        //photos route
        Route::get('photos', [SuperAdminController::class, 'showPhotoList'])->name('photos');
        Route::post('photos', [SuperAdminController::class, 'addPhoto'])->name('photos.store');
        Route::delete('photos/{id}', [SuperAdminController::class, 'deletePhoto'])->name('photos.destroy');
        //admin user route
        Route::get('admin', [SuperAdminController::class, 'showAdminList'])->name('admins.index');
        Route::get('admin/create', [SuperAdminController::class, 'showFormAddAdmin'])->name('admins.store.index');
        Route::post('admin/create', [SuperAdminController::class, 'addUserAdmin'])->name('admins.store');
        Route::get('admin/{id}', [SuperAdminController::class, 'showAdminDetails'])->name('admins.show');
        Route::put('admin/{id}', [SuperAdminController::class, 'updateUserAdmin'])->name('admins.update');
        Route::delete('admin/{id}', [SuperAdminController::class, 'deleteUserAdmin'])->name('admins.destroy');
        //workers user route
        Route::get('workers/create', [SuperAdminController::class, 'showFormAddWorkers'])->name('workers.store.index');
        Route::post('workers/create', [SuperAdminController::class, 'addUserWorkers'])->name('workers.store');
    });
    
    Route::group(['middleware' => ['authorized:admin']], function () {
        Route::resource('admin', AdminController::class);
    });
});
