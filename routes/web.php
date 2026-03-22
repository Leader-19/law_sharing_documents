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
/**
 * End role route
 */

/**
 * Categories route
 */
Route::resource('categories', CategoryController::class)
    ->only(['create', 'store'])
    ->middleware('permission:category.create');
Route::resource('categories', CategoryController::class)
    ->only(['edit', 'update'])
    ->middleware('permission:category.edit');
Route::resource('categories', CategoryController::class)
    ->only(['destroy'])
    ->middleware('permission:category.delete');
Route::resource('categories', CategoryController::class)
    ->only(['index', 'show'])
    ->middleware('permission:category.create|category.edit|category.delete|category.view');

/**
 * End Categories route
 */

/**
 * Documents route
 */
Route::resource('documents', DocumentController::class)
    ->only(['create', 'store'])
    ->middleware('permission:document.create');
Route::resource('documents', DocumentController::class)
    ->only(['edit', 'update'])
    ->middleware('permission:document.edit');;
Route::resource('documents', DocumentController::class)
    ->only(['destroy'])
    ->middleware('permission:document.delete');;
Route::resource('documents', DocumentController::class)
    ->only(['index', 'show'])
    ->middleware('permission:document.create|document.edit|document.delete|document.view');;

/**
 * End Documents route
 */





require __DIR__ . '/settings.php';
