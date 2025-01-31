<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Http\Middleware\ClientAdminMiddleware;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\Admin\ClientAdminController;
use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');

// Super Admin Routes
Route::middleware(['auth', SuperAdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [SuperAdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/clients', [SuperAdminController::class, 'listClients'])->name('admin.clients');
    Route::post('/admin/invite-client', [SuperAdminController::class, 'inviteClient'])->name('admin.invite.client');
    Route::get('/admin/urls', [SuperAdminController::class, 'listUrls'])->name('admin.urls');
    Route::get('/admin/urls/download', [SuperAdminController::class, 'downloadUrls'])->name('admin.urls.download');
});

// Client Admin Routes
Route::middleware(['auth', ClientAdminMiddleware::class])->group(function () {
    Route::get('/client/dashboard', [ClientAdminController::class, 'dashboard'])->name('client.dashboard');
    Route::get('/client/team', [ClientAdminController::class, 'listTeam'])->name('client.team');
    Route::post('/client/invite-team', [ClientAdminController::class, 'inviteTeam'])->name('client.invite.team');
    Route::get('/client/urls', [ClientAdminController::class, 'listUrls'])->name('client.urls');
    Route::get('/client/urls/download', [ClientAdminController::class, 'downloadUrls'])->name('client.urls.download');
});

// URL Shortener Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/generate-url', [UrlController::class, 'generate'])->name('generate.url');
    Route::get('/my-urls', [UrlController::class, 'myUrls'])->name('my.urls');
    Route::get('/my-urls/download', [UrlController::class, 'downloadMyUrls'])->name('my.urls.download');
});

// Logout Route
Route::post('/logout', function () {
    Auth::logout(); 
    return redirect('/login'); 
})->name('logout');