<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function __invoke(): void
    {
        Log::info("TelegramController");
    }
}
