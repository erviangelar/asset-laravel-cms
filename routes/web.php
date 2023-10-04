<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\AnnualBudgetController;
use App\Http\Controllers\AssetTypeController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AllocationBudgetController;
use App\Http\Controllers\AssetPurchaseController;
use App\Http\Controllers\AssetRequestController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MenuAccessController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\WorkflowApprovalController;
use App\Http\Controllers\ApprovalController;

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
    return view('landing');
});
Route::get('/welcome', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/not-found', function () {
//     return view('errors/404');
// })->name('not-found');
// Route::fallback(function () {
//     return view('errors/404');
// })->name('not-found');

Route::group(['prefix' => 'auth'], function () {
    Route::controller(ChangePasswordController::class)
        ->prefix('change-password')
        ->as('auth.')
        ->group(function () {
        Route::get('/', 'showChangePasswordForm')->name('change-password');
        Route::post('/update',  [ChangePasswordController::class, 'changePassword'])->name('change-password.update');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'dashboard/admin'], function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');

        Route::group(['prefix' => 'profile'], function () {
            Route::get('/', [HomeController::class, 'profile'])->name('profile');
            Route::post('update', [HomeController::class, 'updateprofile'])->name('profile.update');
        });

        Route::middleware('role:Super Administrator')->group(function () {
            Route::controller(AccountController::class)
                ->prefix('user')
                ->as('user.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('showdata', 'dataTable')->name('dataTable');
                    Route::match(['get','post'],'create', 'create')->name('create');
                    Route::match(['get','post'],'{id}/edit', 'edit')->name('edit');
                    Route::delete('{id}/hapus', 'delete')->name('delete');
                    Route::delete('{id}/activate', 'activate')->name('activate');
                    Route::delete('{id}/disable', 'disable')->name('disable');
                });

            Route::controller(RoleController::class)
                ->prefix('role')
                ->as('role.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('showdata', 'dataTable')->name('dataTable');
                    Route::match(['get','post'],'create', 'create')->name('create');
                    Route::match(['get','post'],'{id}/update', 'edit')->name('edit');
                    Route::delete('{id}/delete', 'destroy')->name('delete');
                });

            Route::controller(InstitutionController::class)
                ->prefix('institution')
                ->as('institution.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('showdata', 'dataTable')->name('dataTable');
                    Route::match(['get','post'],'create', 'create')->name('create');
                    Route::match(['get','post'],'{id}/update', 'edit')->name('edit');
                    Route::delete('{id}/delete', 'delete')->name('delete');
                    Route::get('/select2options', 'select2Dropdown')->name('select2Dropdown');
                });

            Route::controller(MenuAccessController::class)
                ->prefix('menu-access')
                ->as('menu-access.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('showdata', 'dataTable')->name('dataTable');
                    Route::match(['get','post'],'create', 'create')->name('create');
                    Route::match(['get','post'],'{id}/update', 'edit')->name('edit');
                    Route::delete('{id}/delete', 'destroy')->name('delete');
                    Route::get('/menuAccessList', 'menuAccessList')->name('access-list');
                });
        });

        Route::middleware('role:Super Administrator;Administrator')->group(function () {
            Route::controller(AssetTypeController::class)
                ->prefix('asset-type')
                ->as('asset-type.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('showdata', 'dataTable')->name('dataTable');
                    Route::match(['get','post'],'create', 'create')->name('create');
                    Route::match(['get','post'],'{id}/edit', 'edit')->name('edit');
                    Route::delete('{id}/delete', 'destroy')->name('delete');
            });
            Route::controller(VendorController::class)
                ->prefix('vendor')
                ->as('vendor.')
                ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('showdata', 'dataTable')->name('dataTable');
                Route::match(['get','post'],'create', 'create')->name('create');
                Route::match(['get','post'],'{id}/edit', 'edit')->name('edit');
                Route::delete('{id}/delete', 'destroy')->name('delete');
            });
            Route::controller(LocationController::class)
                ->prefix('location')
                ->as('location.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('showdata', 'dataTable')->name('dataTable');
                    Route::match(['get','post'],'create', 'create')->name('create');
                    Route::match(['get','post'],'{id}/edit', 'edit')->name('edit');
                    Route::delete('{id}/delete', 'destroy')->name('delete');
            });
            Route::controller(CustomFieldController::class)
                ->prefix('custom-field')
                ->as('custom-field.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('showdata', 'dataTable')->name('dataTable');
                    Route::match(['get','post'],'create', 'create')->name('create');
                    Route::match(['get','post'],'{id}/edit', 'edit')->name('edit');
                    Route::delete('{id}/delete', 'destroy')->name('delete');
            });
            Route::controller(WorkflowApprovalController::class)
                ->prefix('workflow')
                ->as('workflow.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('showdata', 'dataTable')->name('dataTable');
                    Route::match(['get','post'],'create', 'create')->name('create');
                    Route::match(['get','post'],'{id}/edit', 'edit')->name('edit');
                    Route::delete('{id}/delete', 'destroy')->name('delete');
            });
            Route::controller(ReportConfigController::class)
                ->prefix('report-config')
                ->as('report-config.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('showdata', 'dataTable')->name('dataTable');
                    Route::match(['get','post'],'create', 'create')->name('create');
                    Route::match(['get','post'],'{id}/edit', 'edit')->name('edit');
                    Route::delete('{id}/delete', 'destroy')->name('delete');
            });
        });

        Route::middleware('role:Super Administrator;Administrator;User')->group(function () {
            Route::controller(AssetController::class)
                ->prefix('asset')
                ->as('asset.')
                ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('showdata', 'dataTable')->name('dataTable');
                Route::get('/create', 'create')->name('create');
            });
            Route::controller(AnnualBudgetController::class)
                ->prefix('annual-budget')
                ->as('annual-budget.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('showdata', 'dataTable')->name('dataTable');
                    Route::match(['get','post'],'create', 'create')->name('create');
                    Route::match(['get','post'],'{id}/edit', 'edit')->name('edit');
                    Route::delete('{id}/delete', 'destroy')->name('delete');
                    Route::get('/getAnnualBudget', 'getAnnualBudget')->name('getAnnualBudget');
            });
            Route::controller(AllocationBudgetController::class)
                ->prefix('allocation-budget')
                ->as('allocation-budget.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('showdata', 'dataTable')->name('dataTable');
                    Route::match(['get','post'],'create', 'create')->name('create');
                    Route::match(['get','post'],'{id}/edit', 'edit')->name('edit');
                    Route::delete('{id}/delete', 'destroy')->name('delete');
            });
            Route::controller(AssetPurchaseController::class)
                ->prefix('asset-purchase')
                ->as('asset-purchase.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('showdata', 'dataTable')->name('dataTable');
                    Route::match(['get','post'],'create', 'create')->name('create');
                    Route::match(['get','post'],'{id}/edit', 'edit')->name('edit');
                    Route::delete('{id}/delete', 'destroy')->name('delete');
            });
            Route::controller(AssetRequestController::class)
                ->prefix('asset-request')
                ->as('asset-request.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('showdata', 'dataTable')->name('dataTable');
                    Route::match(['get','post'],'create', 'create')->name('create');
                    Route::match(['get','post'],'{id}/edit', 'edit')->name('edit');
                    Route::match(['get'],'{id}/view', 'view')->name('view');
                    Route::delete('{id}/delete', 'destroy')->name('delete');
            });
            Route::controller(ApprovalController::class)
                ->prefix('approval')
                ->as('approval.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('showdata', 'dataTable')->name('dataTable');
                    Route::match(['get'],'{id}/show', 'show')->name('show');
                    Route::put('{id}/approve', 'approve')->name('approve');
                    Route::put('{id}/reject', 'reject')->name('reject');
            });
            Route::controller(ReportController::class)
                ->prefix('report')
                ->as('report.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('showdata', 'dataTable')->name('dataTable');
                    Route::match(['get','post'],'create', 'create')->name('create');
                    Route::match(['get','post'],'{id}/edit', 'edit')->name('edit');
            });
        });
    });
});
