<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

/**
 * Dashboard route
 */
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * User routes
 * create, retrieve, update, delete
 */
Route::resource('users', UserController::class)
    ->only(['create', 'store'])
    ->middleware('permission:users.create');

Route::resource('users', UserController::class)
    ->only(['edit', 'update'])
    ->middleware('permission:users.edit');

Route::resource('users', UserController::class)
    ->only(['destroy'])
    ->middleware('permission:users.delete');

Route::resource('users', UserController::class)
    ->only(['index', 'show'])
    ->middleware('permission:users.create|users.edit|users.delete|users.view');

/**
 * Role routes
 */
Route::resource('roles', RoleController::class)
    ->only(['create', 'store'])
    ->middleware('permission:roles.create');

Route::resource('roles', RoleController::class)
    ->only(['edit', 'update'])
    ->middleware('permission:roles.edit');

Route::resource('roles', RoleController::class)
    ->only(['destroy'])
    ->middleware('permission:roles.delete');

Route::resource('roles', RoleController::class)
    ->only(['index', 'show'])
    ->middleware('permission:roles.create|roles.edit|roles.delete|roles.view');


Route::resource('categories', CategoryController::class);

Route::resource('documents', DocumentController::class);

// /**
//  * Internship route
//  */

// Route::resource('internships', CompanyInternshipController::class);

// /**
//  * Interview route
//  */

// Route::resource('company-interviews', CompanyInterviewsController::class);

// /**
//  * Final slide route
//  */

// Route::resource('final-slides', FinalSlideController::class);

// // Show evaluate form (GET)
// Route::get('/final-slides/{slide}/evaluate', [FinalSlideController::class, 'evaluate'])
//     ->name('final-slides.evaluate');


// // Save score (POST)
// Route::post('/final-slides/{slide}/evaluate-score', [FinalSlideController::class, 'evaluateScoreFinalSlide'])
//     ->name('final-slides.evaluate-score');

// /**
//  * Final report route
//  */

// Route::resource('final-reports', FinalReportController::class);

// // Show evaluate form (GET)
// Route::get(
//     '/final-reports/{id}/evaluate',
//     [FinalReportController::class, 'evaluate']
// )->name('final-reports.evaluate');

// // Save score (POST)
// Route::post(
//     '/final-reports/{id}/evaluate-score',
//     [FinalReportController::class, 'evaluateScoreFinalReports']
// )->name('final-reports.evaluate-score');

// /**
//  * Contact Supervisor
//  */

// Route::resource('contact-supervisors', ContactSupervisorController::class);

// /**
//  * weekly worklog route
//  */

// Route::resource('weekly-worklogs', WeeklyWorklogController::class);
// // Show evaluate form (GET)
// Route::get(
//     '/weekly-worklogs/{id}/evaluate',
//     [WeeklyWorklogController::class, 'evaluate']
// )->name('weekly-worklogs.evaluate');

// // Save score (POST)
// Route::post(
//     '/weekly-worklogs/{id}/evaluate-score',
//     [WeeklyWorklogController::class, 'evaluateScoreWeekly']
// )->name('weekly-worklogs.evaluate-score');




require __DIR__ . '/settings.php';
