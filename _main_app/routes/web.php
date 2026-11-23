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
            // Dashboard Overview
            Route::get('/', [ManagementController::class, 'dashboard'])->name('dashboard');

            // 1. Management Player
            Route::get('/players', [ManagementController::class, 'playersIndex'])->name('players.index');
            Route::post('/players/{id}/update', [ManagementController::class, 'updatePlayer'])->name('players.update');
            Route::post('/users/{id}/update-role', [ManagementController::class, 'updateUserRole'])->name('users.updateRole');

            // 2. Management Scrim
            Route::get('/scrims', [ManagementController::class, 'scrimsIndex'])->name('scrims.index');
            Route::get('/scrims/create', [ManagementController::class, 'createScrim'])->name('scrims.create');
            Route::post('/scrims', [ManagementController::class, 'storeScrim'])->name('scrims.store');
            Route::get('/scrims/{id}/edit', [ManagementController::class, 'editScrim'])->name('scrims.edit');
            Route::post('/scrims/{id}/update', [ManagementController::class, 'updateScrim'])->name('scrims.update');
            Route::post('/scrims/{id}/result', [ManagementController::class, 'storeScrimResult'])->name('scrims.result');
            Route::post('/scrims/{id}/status', [ManagementController::class, 'updateScrimStatus'])->name('scrims.status');

            // 3. Management Tour (Tournament)
            Route::get('/tournaments', [ManagementController::class, 'tournamentsIndex'])->name('tournaments.index');
            Route::post('/tournaments', [ManagementController::class, 'storeTournament'])->name('tournaments.store');
            Route::get('/tournaments/{id}', [ManagementController::class, 'showTournament'])->name('tournaments.show');
            Route::post('/tournaments/{id}/update', [ManagementController::class, 'updateTournament'])->name('tournaments.update');
            Route::post('/tournaments/{id}/matches', [ManagementController::class, 'storeTournamentMatch'])->name('tournaments.matches.store');
            Route::post('/tournaments/matches/{id}/update', [ManagementController::class, 'updateTournamentMatch'])->name('tournaments.matches.update');

            // Recruitment Triage
            Route::get('/applications', [ManagementController::class, 'applicationsIndex'])->name('applications.index');
            Route::post('/applications/{id}/process', [ManagementController::class, 'processApplication'])->name('applications.process');
        });
});
