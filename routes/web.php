<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\MpesaController;
use App\Models\TelegramGroupSession;
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
    $session = TelegramGroupSession::where('active', "<>", true)->orderBy('created_at', 'desc')->first();

    $results = DB::select("SELECT
                                        answer_user_id,
                                        telegraph_chats.name,
                                        SUM(is_user_correct + 0) AS total_correct,
                                        AVG(time_to_answer) AS average_timestamp
                                    FROM
                                        trivia_entries
                                    JOIN
                                        telegraph_chats ON telegraph_chats.chat_id = trivia_entries.answer_user_id
                                    WHERE
                                        session_id = ?
                                    GROUP BY
                                        answer_user_id, telegraph_chats.name
                                    ORDER BY
                                        total_correct DESC, average_timestamp
                                ", [$session->id]);

    $firstThreeResults = collect($results)->take(3);

    $firstThreeResults->map(function ($result) {
        $result->name = str_replace("[private] ", "", $result->name);

        return $result;
    });

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
    DB::statement('TRUNCATE TABLE trivia_entries');
    dd("done truncating sessions");
});

Route::get('/handle', [\App\Telegram\TelegramWebHookHandler::class, 'handle']);

include_once "Admin/admin.php";
include_once "Profile/index.php";


