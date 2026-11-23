<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\RosterController;
use Illuminate\Support\Facades\Route;

// Public Endpoints
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/roster', [RosterController::class, 'index'])->name('roster');
Route::get('/matches', [MatchController::class, 'index'])->name('matches');
Route::get('/matches/{id}', [MatchController::class, 'show'])->name('matches.show');
Route::post('/matches/{id}/rsvp', [MatchController::class, 'rsvp'])->name('matches.rsvp');

// Recruitment ("Join Squad")
Route::get('/join-squad', [RecruitmentController::class, 'create'])->name('join.squad');
Route::post('/join-squad', [RecruitmentController::class, 'store'])->name('join.squad.store');

// Tactical Tools / 20v20 Draft & Randomizer
Route::get('/tools/randomizer', function () {
    return view('tools.randomizer');
})->name('tools.randomizer');
Route::redirect('/draft-randomizer', '/tools/randomizer');

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Protected Management / Staff Sector
    Route::middleware('role:superadmin,manager,coach')
        ->prefix('management')
        ->name('management.')
        ->group(function () {
            Route::get('/scrims/create', [ManagementController::class, 'createScrim'])->name('scrims.create');
            Route::post('/scrims', [ManagementController::class, 'storeScrim'])->name('scrims.store');
            Route::get('/applications', [ManagementController::class, 'applicationsIndex'])->name('applications.index');
            Route::post('/applications/{id}/process', [ManagementController::class, 'processApplication'])->name('applications.process');
        });
});
