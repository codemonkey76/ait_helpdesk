<?php

use App\Http\Controllers\Api\UserDefaultFilterController;
use App\Http\Controllers\BugController;
use App\Http\Controllers\CompanyApiController;
use App\Http\Controllers\CompanyNoteController;
use App\Http\Controllers\CompanyNoteSearchController;
use App\Http\Controllers\CompanySearchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\NotePinController;
use App\Http\Controllers\OrganizationNoteController;
use App\Http\Controllers\OrganizationNoteSearchController;
use App\Http\Controllers\OrganizationSearchController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionRoleController;
use App\Http\Controllers\PhoneVerificationController;
use App\Http\Controllers\PhoneVerificationNotificationController;
use App\Http\Controllers\PhoneVerificationPromptController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TicketAgentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketJobCardController;
use App\Http\Controllers\TicketJobController;
use App\Http\Controllers\TicketResponseController;
use App\Http\Controllers\TicketStatusController;
use App\Http\Controllers\TicketSubscriptionController;
use App\Http\Controllers\UserCommunicationPreferencesController;
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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('organizations', OrganizationController::class);
    Route::resource('organizations/{organization}/notes', OrganizationNoteController::class, ['as' => 'organizations']);

    Route::resource('companies', CompanyController::class);
    Route::resource('companies/{company}/notes', CompanyNoteController::class, ['as'=> 'companies']);

    Route::post('notes/{note}/pin', [NotePinController::class, 'store'])->name('notes.pin.store');
    Route::delete('notes/{note}/pin', [NotePinController::class, 'destroy'])->name('notes.pin.destroy');

    Route::resource('notes', NoteController::class);

    Route::resource('tickets', TicketController::class);
    Route::resource('tickets.responses', TicketResponseController::class);
    Route::resource('tickets.jobs', TicketJobController::class);

    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);

    Route::post('/tickets/{ticket}/subscription', [TicketSubscriptionController::class, 'store'])->name('tickets.subscribe');
    Route::delete('tickets/{ticket}/subscription', [TicketSubscriptionController::class, 'destroy'])->name('tickets.unsubscribe');

    Route::patch('tickets/{ticket}/status', [TicketStatusController::class, 'update'])->name('tickets.status.update');
    Route::patch('tickets/{ticket}/agent', [TicketAgentController::class, 'update'])->name('tickets.agent.update');
    Route::patch('/user/filters', [UserDefaultFilterController::class, 'update'])->name('api.user.filters');
    Route::get('/api/companies', [CompanyApiController::class, 'index'])->name('api.companies.index');

    Route::post('/users/{user}/companies', [UserCompanyController::class, 'store'])->name('users.companies.store');
    Route::delete('/users/{user}/companies', [UserCompanyController::class, 'destroy'])->name('users.companies.destroy');

    Route::post('/roles/{role}/permissions', [PermissionRoleController::class, 'store'])->name('roles.permissions.store');
    Route::delete('/roles/{role}/permissions', [PermissionRoleController::class, 'destroy'])->name('roles.permissions.destroy');

    Route::post('/users/{user}/roles', [UserRoleController::class, 'store'])->name('users.roles.store');
    Route::delete('/users/{user}/roles', [UserRoleController::class, 'destroy'])->name('users.roles.destroy');

    Route::get('/phone/verify', PhoneVerificationPromptController::class)->name('phone.verify.notice');
    Route::post('/phone/verification-notification', PhoneVerificationNotificationController::class)->name('phone.verify.send');
    Route::post('/phone/verify', PhoneVerificationController::class)->name('phone.verify');

    Route::post('/tickets/{ticket}/job-card', [TicketJobCardController::class, 'store'])->name('tickets.job-card.store');
    Route::get('/tickets/{ticket}/job-card/create', [TicketJobCardController::class, 'create'])->name('tickets.job-card.create');
    Route::get('/test', [TestController::class, 'test'])->name('test.form');
    Route::post('/test', [TestController::class, 'store'])->name('test.store');
    Route::resource('/bugs', BugController::class);
    Route::patch('/user/communication_preferences', [UserCommunicationPreferencesController::class, 'update'])->name('user-communication-preferences.update');
});




