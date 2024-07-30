<?php

use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Schedule;

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    for ($i = 0; $i <= 20; $i++) {
        (new TelegramController)->__invoke();
        sleep(1);
    }
})
    ->name("Handle Groups")
    ->withoutOverlapping()
    ->everySecond();
