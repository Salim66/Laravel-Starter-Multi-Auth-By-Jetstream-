<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AdminController as BackendAdminController;
use App\Http\Controllers\Frontend\UserController;



Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'admin', 'middleware'=>['admin:admin']], function(){
    Route::get('/login', [AdminController::class, 'loginForm']);
    Route::post('/login', [AdminController::class, 'store'])->name('admin.login');
});

Route::middleware(['auth:sanctum,admin',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
});

Route::middleware(['auth:sanctum,web',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.index');
    })->name('dashboard');
});

// Admin Logout
Route::get('/admin-logout', [AdminController::class, 'destroy'])->name('admin.logout');

// Admin Profile
Route::get('/admin/profile', [BackendAdminController::class, 'adminProfile'])->name('admin.profile');
Route::get('/admin/profile/edit', [BackendAdminController::class, 'adminProfileEdit'])->name('admin.profile.edit');
Route::post('/admin/profile/update', [BackendAdminController::class, 'adminProfileUpdate'])->name('admin.profile.update');
Route::get('/admin/change/password', [BackendAdminController::class, 'adminChangePassword'])->name('admin.change.password');
Route::post('/admin/update/password', [BackendAdminController::class, 'adminUpdatePassword'])->name('admin.password.update');


// Users Routes
// User Logout
Route::get('/user-logout', [UserController::class, 'logout'])->name('user.logout');

// User Profile
Route::get('/user/profile', [UserController::class, 'userProfile'])->name('user.profile');
Route::get('/user/profile/edit', [UserController::class, 'userProfileEdit'])->name('profile.edit');
Route::post('/user/profile/update', [UserController::class, 'userProfileUpdate'])->name('profile.update');
Route::get('/user/change/password', [UserController::class, 'userChangePassword'])->name('change.password');
Route::post('/user/update/password', [UserController::class, 'userUpdatePassword'])->name('password.update');
