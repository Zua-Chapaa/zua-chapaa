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

    $results = DB::select("
                SELECT
                    chats.chat_id,
                    chats.name,
                    AVG(te.time_to_answer) as average_time,
                    SUM(te.is_user_correct) as total
                FROM trivia_entries te
                JOIN telegraph_chats chats ON chats.chat_id = te.user_id
                WHERE te.session_id = $session->id
                GROUP BY chats.chat_id, chats.name
                ORDER BY total DESC, average_time
            ");

    $firstThreeResults = collect($results)->take(3);

    return Inertia::render('Telegram/Leaderboard', [
        'top' => $firstThreeResults
    ]);
});


Route::get('/about', function () {
    return Inertia::render('Telegram/About');
});

Route::get('/faq', function () {
    return Inertia::render('Telegram/Faq');
});


Route::any('/mpesa/callback/{chat}', [MpesaController::class, 'mpesa_callback']);

Route::get('/Schedule', \App\Http\Controllers\TelegramController::class);
Route::get('/truncate', function () {
    DB::statement('TRUNCATE TABLE telegram_group_sessions');
    DB::statement('TRUNCATE TABLE active_session_questions');
    dd("done truncating sessions");
});

Route::get('/handle', [\App\Telegram\TelegramWebHookHandler::class, 'handle']);

include_once "Admin/admin.php";
