<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\QuestionsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/Admin/Register', function () {
    return Inertia::render('Admin/AdminRegistration');
})->name('adminRegistration');


Route::post('/Admin/Register', [AccountController::class, 'register_administrator'])->name('adminRegistrationPost');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {
    Route::get('/users', [AccountController::class, 'get_all_users'])->name('users.index');

    Route::get('/transactions', [OrderController::class, 'List_all_orders'])->name('transactions.index');

    Route::get('/questions', [QuestionsController::class, 'List_Questions'])->name('questions.index');
});
