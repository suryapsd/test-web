<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\User\PermissionController;
use App\Http\Controllers\Master\DokumenWajibController;
use App\Http\Controllers\Master\LayananJenisController;
use App\Http\Controllers\Master\LayananKategoriController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Notifications
    Route::prefix("/notifications")->name('notification.')->group(function () {
        Route::get('/test-notif', [NotificationController::class, 'testNotif'])->name('test-notif');
        Route::get('/read-all', [NotificationController::class, 'readAllNotif'])->name('read-all');
        Route::get("/{id}/read", [NotificationController::class, "read"])->name("read");
    });
    
    Route::get('/home', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('profile', [DashboardController::class, 'profile'])->name('profile.index');
    Route::post('profile/post', [DashboardController::class, 'profilePost'])->name('profile.post');
    Route::post('/update-password', [DashboardController::class, 'updatePassword'])->name('profile.password_update');

    // User
    Route::get('user-account/data', [UserController::class, 'data']);
    Route::post('user-account/update-status/{id}', [UserController::class, 'updateStatus']);
    Route::resource('user-account', UserController::class);
    
    Route::get('roles/data', [RoleController::class, 'data']);
    Route::resource('roles', RoleController::class);
    
    Route::get('permissions/data', [PermissionController::class, 'data']);
    Route::resource('permissions', PermissionController::class);
        
    Route::get('jenis-layanan/data', [LayananJenisController::class, 'data']);
    Route::resource('jenis-layanan', LayananJenisController::class);

    Route::get('kategori-layanan/data', [LayananKategoriController::class, 'data']);
    Route::resource('kategori-layanan', LayananKategoriController::class);

    Route::get('dokumen-wajib/data', [DokumenWajibController::class, 'data']);
    Route::resource('dokumen-wajib', DokumenWajibController::class);
    
});