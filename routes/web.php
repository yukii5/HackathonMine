<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

// プロジェクト 一覧（TOP ）、作成、編集、削除
Route::prefix('/')->middleware('auth')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/project/create', [ProjectController::class, 'create'])->name('project.create');
    Route::post('/project/store', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/project/{id}/edit', [ProjectController::class, 'edit'])->name('project.edit');
    Route::put('/project/{id}/edit', [ProjectController::class, 'update'])->name('project.edit.put');
    Route::delete('/project/{id}/delete', [ProjectController::class, 'delete'])->name('project.delete');
});

// プロジェクト詳細　(チケット一覧)
Route::prefix('/project')->middleware('auth')->group(function () {
    Route::get('/{id}', [ProjectController::class, 'detail'])->name('project.detail');
    Route::put('/{id}/status', [ProjectController::class, 'status'])->name('project.status');
});

// チケット作成、詳細、コメント投稿
Route::prefix('/project/{pid}/ticket')->middleware('auth')->group(function () {
    Route::get('/create', [TicketController::class, 'create']);
    Route::post('/store', [TicketController::class, 'store'])->name('ticket.store');
    Route::get('/{tid}', [TicketController::class, 'show'])->name('ticket.show');
    Route::post('/{tid}', [CommentController::class, 'store']);
    Route::put('/{tid}/status', [TicketController::class, 'status'])->name('ticket.status');
    Route::delete('/{tid}/delete', [TicketController::class, 'delete'])->name('ticket.delete');
    Route::get('/{tid}/edit', [TicketController::class, 'edit'])->name('ticket.edit');
    Route::put('/{tid}/edit', [TicketController::class, 'update'])->name('ticket.edit.put');
});

// コメント 編集、削除
Route::prefix('/comment')->middleware('auth')->group(function() {
    Route::put('/update/{comment}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/delete/{comment}', [CommentController::class, 'destroy'])->name('comment.delete');
});

// メンバー（user）一覧、メンバー情報編集、論理削除
Route::prefix('/users')->middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/{user}/update', [UserController::class, 'update'])->name('user.update');
    Route::put('/{user}/delete', [UserController::class, 'delete'])->name('user.delete');
});

Auth::routes();