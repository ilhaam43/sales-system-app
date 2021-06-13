<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResearcherController;

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
        Route::group(['prefix' => 'product-category'], function () {
            Route::get('/', [SuperAdminController::class, 'showProductCategory'])->name('product-category');
            Route::get('/{id}', [SuperAdminController::class, 'showDetailProductCategory'])->name('product-category.detail');
            Route::post('/', [SuperAdminController::class, 'addProductCategory'])->name('product-category.store');
            Route::put('/{id}', [SuperAdminController::class, 'updateProductCategory'])->name('product-category.update');
            Route::delete('/{id}', [SuperAdminController::class, 'deleteProductCategory'])->name('product-category.destroy');
        });
        //photos route
        Route::group(['prefix' => 'photos'], function () {
            Route::get('/', [SuperAdminController::class, 'showPhotoList'])->name('photos');
            Route::post('/', [SuperAdminController::class, 'addPhoto'])->name('photos.store');
            Route::delete('/{id}', [SuperAdminController::class, 'deletePhoto'])->name('photos.destroy');
        });
        //all users route
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [SuperAdminController::class, 'showUsersList'])->name('users.index');
            Route::get('/{id}', [SuperAdminController::class, 'showUsersDetails'])->name('users.show');
            Route::put('/{id}', [SuperAdminController::class, 'updateUsers'])->name('users.update');
            Route::delete('/{id}', [SuperAdminController::class, 'deleteUsers'])->name('users.destroy');
        });
        //admin user route
        Route::group(['prefix' => 'admin'], function () {
            Route::get('/', [SuperAdminController::class, 'showAdminList'])->name('admins.index');
            Route::get('/create', [SuperAdminController::class, 'showFormAddAdmin'])->name('admins.store.index');
            Route::post('/create', [SuperAdminController::class, 'addUserAdmin'])->name('admins.store');
            Route::get('/{id}', [SuperAdminController::class, 'showAdminDetails'])->name('admins.show');
            Route::put('/{id}', [SuperAdminController::class, 'updateUserAdmin'])->name('admins.update');
            Route::delete('/{id}', [SuperAdminController::class, 'deleteUserAdmin'])->name('admins.destroy');
        });
        //workers user route
        Route::group(['prefix' => 'workers'], function () {
            Route::get('/create', [SuperAdminController::class, 'showFormAddWorkers'])->name('workers.store.index');
            Route::post('/create', [SuperAdminController::class, 'addUserWorkers'])->name('workers.store');
            Route::get('/{workers}', [SuperAdminController::class, 'showWorkersList'])->name('workers.index');
            Route::get('/{workers}/{id}', [SuperAdminController::class, 'showWorkersDetails'])->name('workers.show');
            Route::put('/{workers}/{id}', [SuperAdminController::class, 'updateUserWorkers'])->name('workers.update');
            Route::delete('/{workers}/{id}', [SuperAdminController::class, 'deleteUserWorkers'])->name('workers.destroy');
        });
        //settings general route
        Route::group(['prefix' => 'setting'], function () {
            Route::get('/', [SuperAdminController::class, 'showGeneralSetting'])->name('settings.index');
            Route::get('/create', [SuperAdminController::class, 'showFormAddGeneralSetting'])->name('settings.store.index');
            Route::post('/create', [SuperAdminController::class, 'addGeneralSetting'])->name('settings.store');
            Route::get('/{id}', [SuperAdminController::class, 'showDetailGeneralSetting'])->name('settings.detail');
            Route::put('/{id}', [SuperAdminController::class, 'updateGeneralSetting'])->name('settings.update');
            Route::delete('/{id}', [SuperAdminController::class, 'deleteGeneralSetting'])->name('settings.destroy');
        });
    });
    
    Route::group(['middleware' => ['authorized:admin']], function () {
        Route::resource('admin', AdminController::class);
    });

    Route::group(['prefix' => 'researcher', 'middleware' => ['authorized:researcher']], function () {
        Route::get('/', [ResearcherController::class, 'index'])->name('researcher.index');
        Route::get('/faq', [ResearcherController::class, 'showFAQ'])->name('researcher.faq');
        Route::get('/notice', [ResearcherController::class, 'showNotice'])->name('researcher.notice');
        Route::get('/my-work', [ResearcherController::class, 'showMyWork'])->name('researcher.mywork');
        Route::get('/payments', [ResearcherController::class, 'showPayments'])->name('researcher.payments');
        Route::post('/add-company', [ResearcherController::class, 'addCompanyData'])->name('researcher.store.company');
        Route::post('/check-company', [ResearcherController::class, 'checkCompanyData'])->name('researcher.check.company');
        Route::get('/country-records', [ResearcherController::class, 'showCountryRecords'])->name('researcher.countyrecords');
        Route::get('/profile', [ResearcherController::class, 'showProfile'])->name('researcher.profile');
        Route::put('/profile', [ResearcherController::class, 'updateProfile'])->name('researcher.update');
        Route::get('/researches', [ResearcherController::class, 'showResearches'])->name('researcher.researches');
        Route::get('/researches/{id}', [ResearcherController::class, 'showDetailResearches'])->name('researcher.detail.researches');
        Route::put('/researches/{id}', [ResearcherController::class, 'updateResearches'])->name('researcher.update.researches');
    });
});
