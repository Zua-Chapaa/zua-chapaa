<?php

namespace App\Telegram\CallBacks;

use App\Http\Controllers\MpesaController;
use App\Telegram\CallBacks\Home\Home;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;

trait HandleChatMessage
{
    use GetChat;
    use Home;

    protected MpesaController $m_pesa_controller;

    public function __construct(MpesaController $m_pesa_controller)
    {
        $this->m_pesa_controller = $m_pesa_controller;
    }

    private function goToHome($text = null): void
    {
        if (empty($this->getChat()->storage()->get('user_context'))) {
            $this->getChat()->message('Select a plan')
                ->keyboard(Keyboard::make()->row([
                    Button::make('Hourly Plan @Ksh 100')
                        ->action('select_plan')
                        ->param('plan', 'hourly'),

                    Button::make('Day Plan @Ksh 1500')
                        ->action('select_plan')
                        ->param('plan', 'daily'),
                ]))->send();

        } else {
            if (!$this->validateNumber($text)) {

                // Advice user on corrections
                $this->getChat()
                    ->message("Invalid number. Accepted Format: \n\n 07******** \n +2547******** \n 2547******** \n")
                    ->keyboard(Keyboard::make()->row([
                        Button::make('Try Again')
                            ->action('invalid_phone_number')
                            ->param('subscription_option', 'Try Again'),

                        Button::make("Cancel")
                            ->action('invalid_phone_number')
                            ->param('subscription_option', 'Cancel'),
                    ]))->send();

            } else {
//                $this->getChat()->storage()->set('user_context', "");
                $this->msg("A request will be made to your number");
                $this->msg("Please accept the requested payment to continue");
                $this->m_pesa_controller->sendRequest($this->getChat());
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


}
