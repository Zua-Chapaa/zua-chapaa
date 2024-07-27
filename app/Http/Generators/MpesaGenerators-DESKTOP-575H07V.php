<?php

namespace App\Http\Generators;

use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Stringable;

trait MpesaGenerators
{
    public function basicAuthorisation(TelegraphChat $chat): string
    {
        $credentials = env('MPESA_CONSUMER_KEY') . ":" . env('MPESA_CONSUMER_SECRET');
        return base64_encode($credentials);
    }

    public function data_generator(TelegraphChat $chat, Stringable $text): array
    {
        $businessShortCode = env('BUSINESS_SHORT_CODE');
        $timestamp = date("YmdHis");
        $passKey = env('PASS_KEY');
        $amount = $chat->storage()->get('plan') == 'hourly' ? 1 : 2;

        return [
            "encoded_string" => base64_encode($businessShortCode . $passKey . $timestamp),
            "timestamp" => $timestamp,
            "amount" => $amount
        ];
    }
}


