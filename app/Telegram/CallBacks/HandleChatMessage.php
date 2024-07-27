<?php

namespace App\Telegram\CallBacks;

use App\Http\Controllers\MpesaController;
use App\Models\User;
use App\Telegram\CallBacks\Home\Home;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;

trait HandleChatMessage
{
    use GetChat;
    use Home;

    protected MpesaController $m_pesa_controller;

    private function goToHome($text = null): void
    {
        $chat = $this->getChat();
        $user_context = $chat->storage()->get('user_context');


        if ($user_context == 'subscribing') {
            $chat->storage()->set('user_context', 'subscribing');
            $chat->message('Select a plan')
                ->keyboard(Keyboard::make()->row([
                    Button::make('Hourly Plan @Ksh 100')->action('select_plan')->param('plan', 'hourly'),
                    Button::make('Day Plan @Ksh 1500')->action('select_plan')->param('plan', 'daily'),
                ]))->send();
        }

        if ($user_context == 'phone_number_request_mode') {
            if ($this->validateNumber($text)) {

                //reset user context
                $this->getChat()->storage()->set('user_context', "");

                //inform user of mpesa request
                $this->msg("Please accept the payment requested to continue");

                //TODO::reset
                $this->m_pesa_controller->sendRequest($this->getChat(), $text);
            } else {
                // Advice user on corrections
                $this->getChat()
                    ->message("Invalid number. Accepted Format: 2547******** \n")
                    ->keyboard(Keyboard::make()->row([
                        Button::make('Try Again')
                            ->action('invalid_phone_number')
                            ->param('subscription_option', 'Try Again'),
                        Button::make("Cancel")
                            ->action('invalid_phone_number')
                            ->param('subscription_option', 'Cancel'),
                    ]))->send();
            }
        }


        if ($user_context == null) {
            $user_has_active_subscription = $this->has_active_subscription();

            if ($user_has_active_subscription) {

                $user = User::where('telegram_id', $this->getChat()->id)->first();

                if (!is_null($user->name)) {
                    $result = trim(str_replace('[private]', '', $user->name));
                    $user->name = $result;
                    $user->save();

                    $chat->message("You are currently on $user->active_subscription plan")
                        ->keyboard(Keyboard::make()->row([
                            Button::make('Begin Trivia')->action('start_trivia'),
                            Button::make('Cancel Plan')->action('cancel_active_plan')
                        ]))->send();
                } else {
                    $chat->messga("Please Update your telegram username to proceed");
                }



            } else {
                $chat->storage()->set('user_context', 'subscribing');
                $chat->message('Select a plan')
                    ->keyboard(Keyboard::make()->row([
                        Button::make('Hourly Plan @Ksh 100')->action('select_plan')->param('plan', 'hourly'),
                        Button::make('Day Plan @Ksh 1500')->action('select_plan')->param('plan', 'daily'),
                    ]))->send();
            }
        }


    }

    private function goToLeadersBoard()
    {

    }

    private function goToAbout()
    {

    }

    private function checkBalance()
    {

    }

    private function viewAccount()
    {

    }

    private function viewFAQ()
    {

    }

    private function defaultResponse(): void
    {
//        $this->goToHome();
    }

    public function setMpesaController(MpesaController $m_pesa_controller): void
    {
        $this->m_pesa_controller = $m_pesa_controller;
    }
}
