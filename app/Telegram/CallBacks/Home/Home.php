<?php

namespace App\Telegram\CallBacks\Home;

use App\Telegram\CallBacks\GetChat;
use Illuminate\Support\Stringable;

trait Home
{
    use GetChat;
    public function invalid_phone_number_action(): void
    {
        $action = $this->data->get('action');

        if ($action == 'Try Again') {
            $this->select_plan();
        } else {
            $this?->getChat()
                ->message("Home")
                ->send();
        }
    }
    public function select_plan(): void
    {
        $this->getChat()->storage()->set('user_context', "phone_number_request_mode");
        $this->getChat()->storage()->set('plan', $this->data->get('plan'));


        $this?->getChat()
            ->message("Please Enter your number to proceed")
            ->send();
    }

    public function validateNumber(Stringable $text): mixed
    {
        $text = (string)$text;

        $patterns = [
            '/^07\d{8}$/',            // 07********
            '/^\+2547\d{8}$/',        // +2547********
            '/^2547\d{8}$/'           // 2547********
        ];

        // Check if the phone number matches any of the patterns
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text)) {
                // Convert the phone number to a numeric value
                return preg_replace('/\D/', '', $text);
            }
        }

        // If the phone number doesn't match any pattern, return false or an error message
        return false;
    }
}
