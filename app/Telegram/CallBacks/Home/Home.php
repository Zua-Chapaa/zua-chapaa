<?php

namespace App\Telegram\CallBacks\Home;

use App\Models\User;
use App\Telegram\CallBacks\GetChat;

trait Home
{
    use GetChat;

    public function select_plan(): void
    {
        //set context
        $this->getChat()->storage()->set('user_context', "phone_number_request_mode");

        //plan selected
        $this->getChat()->storage()->set('plan', $this->data->get('plan'));

        //enquire phone number
        $this?->getChat()->message("Please Enter your number to proceed")->send();
    }

    public function validateNumber($text): mixed
    {
        $text = (string)$text;

        $patterns = [
            '/^2547\d{8}$/',       // 2547********
            '/^07\d{8}$/'          // 2547********
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


    public function invalid_phone_number(): void
    {
        //enquire to continue
        if ($this->data->get('subscription_option') == 'Try Again') {
            $this->select_plan();
        } else {
            $this->msg("Subscription canceled");
            $this->getChat()->storage()->set('user_context', "");
        }
    }

    public function has_active_subscription(): bool
    {
        $user = User::where('telegram_id', $this->getChat()->id)->first();
        if ($user->active_subscription != null) {
            return true;
        }
        return false;
    }

    public function cancel_active_plan(): void
    {
        $user = User::where('telegram_id', $this->getChat()->id)->first();
        $user->active_subscription = null;
        $user->save();
        $this->msg("Subscription cancelled");
    }

    public function start_trivia(): void
    {
        $this->msg("https://t.me/+EZAMREqY0QA1Y2Rk");
    }

}
