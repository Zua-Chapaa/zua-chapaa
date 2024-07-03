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
        if (empty($this->getChat()->storage()->get('user_context'))) {

            $chat = $this->getChat();
            $account = User::where('telegram_id', $chat->id)->first();
            $has_active_subscription = boolval($account->active_subscription != null);

            if ($has_active_subscription) {
                $chat->message("You are currently on the $account->active_subscription Hourly plan")->send();
            } else {
                $this->getChat()->message('Select a plan')
                    ->keyboard(Keyboard::make()->row([
                        Button::make('Hourly Plan @Ksh 100')
                            ->action('select_plan')
                            ->param('plan', 'hourly'),
                        Button::make('Day Plan @Ksh 1500')
                            ->action('select_plan')
                            ->param('plan', 'daily'),
                    ]))->send();
            }
        } else {
            if (!$this->validateNumber($text)) {

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

            } else {
                //reset user context
                $this->getChat()->storage()->set('user_context', "");

                //inform user of mpesa request
                $this->msg("Please accept the payment requested to continue");

                //TODO::reset
                $this->m_pesa_controller->sendRequest($this->getChat(), $text);
            }
        }

//        if (
//            !empty($this->getChat()->storage()->get('user_context')) &&
//            $this->getChat()->storage()->get('user_context') == 'phone_number_request_mode'
//        ) {
//            Log::info($this->validateNumber($text));
//
//            if (!$this->validateNumber($text)) {
//
//                //reset context
//                $this->getChat()->storage()->set('user_context', "");
//
//
//            }else{
////make a payment request
//                $this->getChat()->message("Please accept the payment request made to continue.");
//            }
//        }else{
//            //application not in subscription mode
//
//            $this->getChat()->message('Select a plan to proceed')
//                ->keyboard(Keyboard::make()->row([
//                    Button::make('Hourly Plan @Ksh 100')
//                        ->action('select_plan')
//                        ->param('plan', 'hourly'),
//
//                    Button::make('Day Plan @Ksh 1500')
//                        ->action('select_plan')
//                        ->param('plan', 'daily'),
//                ]))->send();
//        }

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
