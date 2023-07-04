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

// TOP （プロジェクト一覧）
Route::get('/', [App\Http\Controllers\ProjectController::class, 'index'])
->middleware('auth')->name('projects.index');

Route::get('/project/create', [App\Http\Controllers\ProjectController::class, 'create'])
->middleware('auth')->name('project.create');

Route::post('/project/store', [App\Http\Controllers\ProjectController::class, 'store'])
->middleware('auth')->name('project.store');

Route::get('/project/{id}/edit', [App\Http\Controllers\ProjectController::class, 'edit'])
->middleware('auth')->name('project.edit');

// プロジェクト詳細　(チケット一覧)
Route::get('/project/{id}', [App\Http\Controllers\ProjectController::class, 'detail'])
->middleware('auth')->name('project.detail');

// チケット作成
Route::get('/project/{id}/ticket/create', [App\Http\Controllers\TicketController::class, 'create'])
->middleware('auth');

Route::post('/project/{id}/ticket/store', [App\Http\Controllers\TicketController::class, 'store'])
->middleware('auth')->name('ticket.store');


// チケット詳細
Route::get('/project/{pid}/ticket/{tid}', [App\Http\Controllers\TicketController::class, 'show'])
->middleware('auth')->name('ticket.show');

Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])
->middleware('auth')->name('user.index');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
