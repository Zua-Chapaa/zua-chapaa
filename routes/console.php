<?php

use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Schedule;

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//})->purpose('Display an inspiring quote')->hourly();

Schedule::call(new TelegramController)
    ->name("Handle Groups")
    ->withoutOverlapping()
    ->everySecond();
