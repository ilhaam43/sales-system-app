<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResearcherController;
use App\Http\Controllers\InqurierController;
use App\Http\Controllers\AuditorController;
use App\Http\Controllers\AjaxDataResearchesController;
use App\Http\Controllers\AjaxDataInquiriesController;
use App\Http\Controllers\AjaxDataAuditorController;
use App\Http\Controllers\AjaxDataUsersController;

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
        
        //all users route
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [SuperAdminController::class, 'showUsersList'])->name('users.index');
            Route::post('/block', [SuperAdminController::class, 'blockUsers'])->name('users.block');
            Route::get('/{id}', [SuperAdminController::class, 'showUsersDetails'])->name('users.show');
            Route::put('/{id}', [SuperAdminController::class, 'updateUsers'])->name('users.update');
            Route::delete('/{id}', [SuperAdminController::class, 'deleteUsers'])->name('users.destroy');

            Route::group(['prefix' => 'data'], function () {
                Route::get('/all/', [AjaxDataUsersController::class, 'showDataUsers'])->name('users.data.all');
            });
        });
        //admin user route
        Route::group(['prefix' => 'admin'], function () {
            Route::get('/', [SuperAdminController::class, 'showAdminList'])->name('admins.index');
            Route::get('/create', [SuperAdminController::class, 'showFormAddAdmin'])->name('admins.store.index');
            Route::post('/create', [SuperAdminController::class, 'addUserAdmin'])->name('admins.store');
            Route::get('/{id}', [SuperAdminController::class, 'showAdminDetails'])->name('admins.show');
            Route::put('/{id}', [SuperAdminController::class, 'updateUserAdmin'])->name('admins.update');
            Route::delete('/{id}', [SuperAdminController::class, 'deleteUserAdmin'])->name('admins.destroy');

            Route::group(['prefix' => 'data'], function () {
                Route::get('/all/', [AjaxDataUsersController::class, 'showDataAdmins'])->name('admins.data.all');
            });
        });
        //workers user route
        Route::group(['prefix' => 'workers'], function () {
            Route::get('/create', [SuperAdminController::class, 'showFormAddWorkers'])->name('workers.store.index');
            Route::post('/create', [SuperAdminController::class, 'addUserWorkers'])->name('workers.store');
            Route::get('/{workers}', [SuperAdminController::class, 'showWorkersList'])->name('workers.index');
            Route::get('/{workers}/{id}', [SuperAdminController::class, 'showWorkersDetails'])->name('workers.show');
            Route::put('/{workers}/{id}', [SuperAdminController::class, 'updateUserWorkers'])->name('workers.update');
            Route::delete('/{workers}/{id}', [SuperAdminController::class, 'deleteUserWorkers'])->name('workers.destroy');

            Route::get('/{workers}/data/all/', [AjaxDataUsersController::class, 'showDataWorkers'])->name('workers.data.all');
        });
        
    });
    
    Route::group(['prefix' => 'admin', 'middleware' => ['authorized:admin']], function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');

        //photos route
        Route::group(['prefix' => 'photos'], function () {
            Route::get('/', [AdminController::class, 'showPhotoList'])->name('admin.photos');
            Route::post('/', [AdminController::class, 'addPhoto'])->name('admin.photos.store');
            Route::delete('/{id}', [AdminController::class, 'deletePhoto'])->name('admin.photos.destroy');
        });
        //all users route
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [AdminController::class, 'showUsersList'])->name('admin.users.index');
            Route::post('/block', [AdminController::class, 'blockUsers'])->name('admin.users.block');
            Route::get('/{id}', [AdminController::class, 'showUsersDetails'])->name('admin.users.show');
            Route::put('/{id}', [AdminController::class, 'updateUsers'])->name('admin.users.update');
            Route::delete('/{id}', [AdminController::class, 'deleteUsers'])->name('admin.users.destroy');

            Route::group(['prefix' => 'data'], function () {
                Route::get('/all/', [AjaxDataUsersController::class, 'allDataUsers'])->name('admin.users.data.all');
            });
        });
        //workers user route
        Route::group(['prefix' => 'workers'], function () {
            Route::get('/{workers}', [AdminController::class, 'showWorkersList'])->name('admin.workers.index');
            Route::get('/{workers}/{id}', [AdminController::class, 'showWorkersDetails'])->name('admin.workers.show');
            Route::put('/{workers}/{id}', [AdminController::class, 'updateUserWorkers'])->name('admin.workers.update');
            Route::delete('/{workers}/{id}', [AdminController::class, 'deleteUserWorkers'])->name('admin.workers.destroy');
            
            Route::get('/{workers}/data/all/', [AjaxDataUsersController::class, 'allDataWorkers'])->name('admin.workers.data.all');
        });

        //researches route
        Route::group(['prefix' => 'researches'], function () {
            Route::get('/', [AdminController::class, 'showAllResearches'])->name('admin.researches.index');
            Route::get('/export-approved-excel', [AdminController::class, 'exportApprovedResearches'])->name('admin.export.approved.excel');
            Route::get('/approved', [AdminController::class, 'showApprovedResearches'])->name('admin.researches.approved');
            Route::get('/pending', [AdminController::class, 'showPendingResearches'])->name('admin.researches.pending');
            Route::get('/rejected', [AdminController::class, 'showRejectedResearches'])->name('admin.researches.rejected');
            Route::get('/removed', [AdminController::class, 'showRemovedResearches'])->name('admin.researches.removed');
            Route::post('/approve', [AdminController::class, 'approveResearches'])->name('admin.researches.approve');
            Route::post('/reject', [AdminController::class, 'rejectResearches'])->name('admin.researches.reject');
            Route::post('/blacklist', [AdminController::class, 'blacklistResearches'])->name('admin.researches.blacklist');

            Route::group(['prefix' => 'data'], function () {
                Route::get('/all/', [AjaxDataResearchesController::class, 'allDataResearches'])->name('admin.researches.data.all');
                Route::get('/approved/', [AjaxDataResearchesController::class, 'approvedDataResearches'])->name('admin.researches.data.approved');
                Route::get('/pending/', [AjaxDataResearchesController::class, 'pendingDataResearches'])->name('admin.researches.data.pending');
                Route::get('/rejected/', [AjaxDataResearchesController::class, 'rejectedDataResearches'])->name('admin.researches.data.rejected');
                Route::get('/removed/', [AjaxDataResearchesController::class, 'removedDataResearches'])->name('admin.researches.data.removed');
            });
        });

        //inquiries route
        Route::group(['prefix' => 'inquiries'], function () {
            Route::get('/', [AdminController::class, 'showAllInquiries'])->name('admin.inquiries.index');
            Route::get('/approved', [AdminController::class, 'showApprovedInquiries'])->name('admin.inquiries.approved');
            Route::get('/pending', [AdminController::class, 'showPendingInquiries'])->name('admin.inquiries.pending');
            Route::get('/rejected', [AdminController::class, 'showRejectedInquiries'])->name('admin.inquiries.rejected');
            Route::get('/removed', [AdminController::class, 'showRemovedInquiries'])->name('admin.inquiries.removed');
            Route::post('/approve', [AdminController::class, 'approveInquiries'])->name('admin.inquiries.approve');
            Route::post('/reject', [AdminController::class, 'rejectInquiries'])->name('admin.inquiries.reject');
            Route::get('/{id}', [AdminController::class, 'showDetailInquiries'])->name('admin.inquiries.show');
            Route::put('/{id}', [AdminController::class, 'updateDetailInquiries'])->name('admin.inquiries.update');

            Route::group(['prefix' => 'data'], function () {
                Route::get('/all/', [AjaxDataInquiriesController::class, 'allDataInquiries'])->name('admin.inquiries.data.all');
                Route::get('/approved/', [AjaxDataInquiriesController::class, 'approvedDataInquiries'])->name('admin.inquiries.data.approved');
                Route::get('/pending/', [AjaxDataInquiriesController::class, 'pendingDataInquiries'])->name('admin.inquiries.data.pending');
                Route::get('/rejected/', [AjaxDataInquiriesController::class, 'rejectedDataInquiries'])->name('admin.inquiries.data.rejected');
                Route::get('/removed/', [AjaxDataInquiriesController::class, 'removedDataInquiries'])->name('admin.inquiries.data.removed');
            });
        });

        //inquiries route
        Route::group(['prefix' => 'reports'], function () {
            Route::get('/', [AdminController::class, 'showAllReports'])->name('admin.reports.index');
        });

        Route::group(['prefix' => 'blacklist'], function () {
            Route::get('/', [AdminController::class, 'showAllBlacklist'])->name('admin.blacklist.index');
        });

        //settings general route
        Route::group(['prefix' => 'setting'], function () {
            Route::get('/', [AdminController::class, 'showGeneralSetting'])->name('admin.settings.index');
            Route::get('/create', [AdminController::class, 'showFormAddGeneralSetting'])->name('admin.settings.store.index');
            Route::post('/create', [AdminController::class, 'addGeneralSetting'])->name('admin.settings.store');
            Route::get('/{id}', [AdminController::class, 'showDetailGeneralSetting'])->name('admin.settings.detail');
            Route::put('/{id}', [AdminController::class, 'updateGeneralSetting'])->name('admin.settings.update');
            Route::delete('/{id}', [AdminController::class, 'deleteGeneralSetting'])->name('admin.settings.destroy');
        });
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

        Route::group(['prefix' => 'data'], function () {
            Route::get('/all/', [AjaxDataResearchesController::class, 'showResearcherData'])->name('researcher.data.all');
        });
    });

    Route::group(['prefix' => 'inqurier', 'middleware' => ['authorized:inqurier']], function () {
        Route::get('/', [InqurierController::class, 'index'])->name('inqurier.index');
        Route::get('/faq', [InqurierController::class, 'showFAQ'])->name('inqurier.faq');
        Route::get('/notice', [InqurierController::class, 'showNotice'])->name('inqurier.notice');
        Route::get('/my-work', [InqurierController::class, 'showMyWork'])->name('inqurier.mywork');
        Route::get('/payments', [InqurierController::class, 'showPayments'])->name('inqurier.payments');
        Route::get('/inquiries', [InqurierController::class, 'showInquiries'])->name('inqurier.inquiries');
        Route::get('/companies', [InqurierController::class, 'showCompanies'])->name('inqurier.companies');
        Route::post('/add-inquiry', [InqurierController::class, 'addInquiryData'])->name('inqurier.store.inquiry');
        Route::post('/add-report', [InqurierController::class, 'addReportData'])->name('inqurier.store.report');
        Route::get('/profile', [InqurierController::class, 'showProfile'])->name('inqurier.profile');
        Route::put('/profile', [InqurierController::class, 'updateProfile'])->name('inqurier.update');

        Route::group(['prefix' => 'data'], function () {
            Route::get('/all/', [AjaxDataInquiriesController::class, 'showInqurierData'])->name('inqurier.data.all');
        });
    });

    Route::group(['prefix' => 'auditor', 'middleware' => ['authorized:auditor']], function () {
        Route::get('/', [AuditorController::class, 'index'])->name('auditor.index');
        Route::get('/faq', [AuditorController::class, 'showFAQ'])->name('auditor.faq');
        Route::get('/notice', [AuditorController::class, 'showNotice'])->name('auditor.notice');
        Route::get('/my-work', [AuditorController::class, 'showMyWork'])->name('auditor.mywork');
        Route::get('/payments', [AuditorController::class, 'showPayments'])->name('auditor.payments');
        Route::get('/profile', [AuditorController::class, 'showProfile'])->name('auditor.profile');
        Route::put('/profile', [AuditorController::class, 'updateProfile'])->name('auditor.update');
        Route::get('/inquiries', [AuditorController::class, 'showInquiries'])->name('auditor.inquiries');
        Route::get('/researches', [AuditorController::class, 'showResearches'])->name('auditor.researches');
        Route::get('/inquiries/{id}', [AuditorController::class, 'showDetailInquiries'])->name('auditor.detail.inquiries');
        Route::put('/inquiries/{id}', [AuditorController::class, 'updateInquiries'])->name('auditor.update.inquiries');
        Route::get('/researches/{id}', [AuditorController::class, 'showDetailResearches'])->name('auditor.detail.researches');
        Route::put('/researches/{id}', [AuditorController::class, 'updateResearches'])->name('auditor.update.researches');

        Route::group(['prefix' => 'data'], function () {
            Route::get('/researches/', [AjaxDataAuditorController::class, 'showResearchesData'])->name('auditor.researches.data');
            Route::get('/inquiries/', [AjaxDataAuditorController::class, 'showInquiriesData'])->name('auditor.inquiries.data');
        });

    });
});
