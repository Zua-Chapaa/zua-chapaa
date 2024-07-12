<?php

use App\Http\Controllers\AccountController;
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

    Route::get('/transactions', function () {
        return Inertia::render('Application/Transactions/index');
    })->name('transactions.index');

    Route::get('/questions', function () {
        return Inertia::render('Application/Questions/index');
    })->name('questions.index');
});
