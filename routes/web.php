<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\MpesaController;
use App\Models\TelegramGroupSession;
use App\Models\TriviaEntry;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('/account/{TelegraphChatID}', [AccountController::class, 'account'])->name('account');


Route::get('/balance/{TelegraphChatID}', function ($TelegraphChatID) {
    return Inertia::render('Telegram/Balance');
});

Route::get('/leaderboard', function () {
    $trivia = TriviaEntry::all();

    $session = TelegramGroupSession::where('active', "<>", true)->orderBy('created_at', 'desc')->first();

    $topUsers = TriviaEntry::select('user_id',
        DB::raw('COUNT(*) as points'))
        ->where('is_user_correct', true)
        ->where('session_id', $session->session_id)
        ->groupBy('user_id')
        ->orderByDesc('points')
        ->limit(5)
        ->get();

    dd($topUsers);


    return Inertia::render('Telegram/Leaderboard');
});


Route::get('/about', function () {
    return Inertia::render('Telegram/About');
});

Route::get('/faq', function () {
    return Inertia::render('Telegram/Faq');
});


Route::any('/mpesa/callback/{chat}', [MpesaController::class, 'mpesa_callback']);

Route::get('/Schedule', \App\Http\Controllers\TelegramController::class);

Route::get('/handle', [\App\Telegram\TelegramWebHookHandler::class, 'handle']);

include_once "Admin/admin.php";
