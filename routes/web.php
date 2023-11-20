<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HRMController;
use App\Http\Controllers\Admin\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth.admin')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'show'])->name('show-login-admin');
    Route::post('/admin/login/auth', [LoginController::class, 'login'])->name('login-admin');
    Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout-admin');

    Route::prefix('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'show'])->name('admin-dashboard');

        Route::prefix('users')->group(function () {
            Route::get('list', [HRMController::class, 'listUser'])->name('users/list');

            Route::get('detail/{id}', [HRMController::class, 'detailUser'])->name('users/detail')->whereNumber('id');

            Route::get('add', [HRMController::class, 'showAddUser'])->name('users/add');
            Route::post('add-submit', [HRMController::class, 'submitAddUser'])->name('users/add-submit');

            Route::get('edit/{id?}', [HRMController::class, 'showEditUser'])->name('users/edit')->whereNumber('id');
            Route::post('edit-submit/{id?}', [HRMController::class, 'submitEditUser'])->name('users/edit-submit')->whereNumber('id');
        });
        Route::prefix('role')->group(function () {
            Route::get('list', [HRMController::class, 'listRole'])->name('role/list');
            Route::get('register', [HRMController::class, 'formRegisterRole'])->name('role/register');
            Route::post('register-submit', [HRMController::class, 'registerRole'])->name('role/register-submit');
        });
    });
});
