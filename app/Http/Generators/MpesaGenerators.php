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
        $amount = $chat->storage()->get('plan') == 'hourly' ? 1 : 2;
        $timestamp = time();
        $passKey = env('MPESA_CONSUMER_KEY') . ":" . env('MPESA_CONSUMER_SECRET');
        $businessShortCode = env('BUSINESS_SHORT_CODE');

        return [
            "encoded_string" => base64_encode($businessShortCode . $timestamp . $passKey),
            "timestamp" => $timestamp,
            "amount" => $amount
        ];
    }
}
