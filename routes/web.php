<?php

use App\Http\Controllers\Api\UserDefaultFilterController;
use App\Http\Controllers\CompanyApiController;
use App\Http\Controllers\CompanyNoteController;
use App\Http\Controllers\CompanyNoteSearchController;
use App\Http\Controllers\CompanySearchController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\NoteFavoriteController;
use App\Http\Controllers\OrganizationNoteController;
use App\Http\Controllers\OrganizationNoteSearchController;
use App\Http\Controllers\OrganizationSearchController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketResponseController;
use App\Http\Controllers\TicketStatusController;
use App\Http\Controllers\TicketSubscriptionController;
use App\Http\Controllers\UserCompanyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
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
    Route::resource('organizations/{organization}/notes', OrganizationNoteController::class, ['as' => 'organizations']);

    Route::resource('companies', CompanyController::class);
    Route::resource('companies/{company}/notes', CompanyNoteController::class, ['as'=> 'companies']);

    Route::post('notes/{note}/favorite', [NoteFavoriteController::class, 'store'])->name('notes.favorite.store');
    Route::delete('notes/{note}/favorite', [NoteFavoriteController::class, 'destroy'])->name('notes.favorite.destroy');

    Route::resource('notes', NoteController::class);

    Route::resource('tickets', TicketController::class);
    Route::resource('tickets.responses', TicketResponseController::class);

    Route::resource('users', UserController::class);

    Route::post('/tickets/{ticket}/subscription', [TicketSubscriptionController::class, 'store'])->name('tickets.subscribe');
    Route::delete('tickets/{ticket}/subscription', [TicketSubscriptionController::class, 'destroy'])->name('tickets.unsubscribe');

    Route::patch('tickets/{ticket}/status', [TicketStatusController::class, 'update'])->name('tickets.status.update');
    Route::patch('/user/filters', [UserDefaultFilterController::class, 'update'])->name('api.user.filters');
    Route::get('/api/companies', [CompanyApiController::class, 'index'])->name('api.companies.index');
    Route::post('/users/{user}/companies', [UserCompanyController::class, 'store'])->name('users.companies.store');
    Route::delete('/users/{user}/companies', [UserCompanyController::class, 'destroy'])->name('users.companies.destroy');

    Route::post('/users/{user}/roles', [UserRoleController::class, 'store'])->name('users.roles.store');
    Route::delete('/users/{user}/roles', [UserRoleController::class, 'destroy'])->name('users.roles.destroy');
});




