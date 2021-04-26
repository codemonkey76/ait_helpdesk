<?php

use App\Http\Controllers\CompanySearchController;
use App\Http\Controllers\OrganizationSearchController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\CompanyController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('organizations', OrganizationController::class);
    Route::post('organizations/search', [OrganizationSearchController::class, 'index'])->name('organizations.search');

    Route::resource('companies', CompanyController::class);
    Route::post('companies/search', [CompanySearchController::class, 'index'])->name('companies.search');
});




