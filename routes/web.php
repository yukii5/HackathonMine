<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\ProjectController::class, 'index'])
->middleware('auth')->name('projects.index');

Route::get('/project/create', [App\Http\Controllers\ProjectController::class, 'create'])
->middleware('auth')->name('projects.create');

Route::post('/project/create', [App\Http\Controllers\ProjectController::class, 'store'])
->middleware('auth')->name('projects.store');

Route::get('/project/{id}', [App\Http\Controllers\ProjectController::class, 'detail'])
->middleware('auth')->name('projects.detail');

Route::get('/ticket/{id}', [App\Http\Controllers\ProjectController::class, 'ticket'])
->middleware('auth')->name('ticket.detail');

Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])
->middleware('auth')->name('user.index');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
