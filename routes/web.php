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
        Route::get('/', [SuperAdminController::class, 'index'])->name('superadmin-index');

        Route::get('product-category', [SuperAdminController::class, 'showProductCategory'])->name('product-category');
        Route::get('product-category/{id}', [SuperAdminController::class, 'showDetailProductCategory'])->name('product-category.detail');
        Route::post('product-category', [SuperAdminController::class, 'addProductCategory'])->name('product-category.add');
        Route::put('product-category/{id}', [SuperAdminController::class, 'updateProductCategory'])->name('product-category.update');
        Route::delete('product-category/{id}', [SuperAdminController::class, 'deleteProductCategory'])->name('product-category.destroy');
    });
    
    Route::group(['middleware' => ['authorized:admin']], function () {
        Route::resource('admin', AdminController::class);
    });
});
