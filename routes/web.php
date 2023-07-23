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

Route::put('/project/{id}/edit', [App\Http\Controllers\ProjectController::class, 'update'])
->middleware('auth')->name('project.edit.put');

Route::delete('/project/{id}/delete', [App\Http\Controllers\ProjectController::class, 'delete'])
->middleware('auth')->name('project.delete');

// プロジェクト詳細　(チケット一覧)
Route::get('/project/{id}', [App\Http\Controllers\ProjectController::class, 'detail'])
->middleware('auth')->name('project.detail');

// プロジェクト ステータス更新
Route::put('/project/{id}/status', [App\Http\Controllers\ProjectController::class, 'status'])
->middleware('auth')->name('project.status');

// チケット作成
Route::get('/project/{id}/ticket/create', [App\Http\Controllers\TicketController::class, 'create'])
->middleware('auth');

Route::post('/project/{id}/ticket/store', [App\Http\Controllers\TicketController::class, 'store'])
->middleware('auth')->name('ticket.store');

// チケット詳細
Route::get('/project/{pid}/ticket/{tid}', [App\Http\Controllers\TicketController::class, 'show'])
->middleware('auth')->name('ticket.show');

// チケットにコメント
Route::post('/project/{pid}/ticket/{tid}', [App\Http\Controllers\CommentController::class, 'store'])
->middleware('auth');

// コメント編集
Route::put('/comment/update/{comment}', [App\Http\Controllers\CommentController::class, 'update'])
->middleware('auth')->name('comment.update');

// コメント削除
Route::delete('/comment/delete/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])
->middleware('auth')->name('comment.delete');

// チケット ステータス更新
Route::put('/project/{pid}/ticket/{tid}/status', [App\Http\Controllers\TicketController::class, 'status'])
->middleware('auth')->name('ticket.status');

Route::delete('/project/{pid}/ticket/{tid}/delete', [App\Http\Controllers\TicketController::class, 'delete'])
->middleware('auth')->name('ticket.delete');

Route::get('/project/{pid}/ticket/{tid}/edit', [App\Http\Controllers\TicketController::class, 'edit'])
->middleware('auth')->name('ticket.edit');

Route::put('/project/{pid}/ticket/{tid}/edit', [App\Http\Controllers\TicketController::class, 'update'])
->middleware('auth')->name('ticket.edit.put');

Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])
->middleware('auth')->name('user.index');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
