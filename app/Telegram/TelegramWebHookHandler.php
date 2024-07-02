<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Telegram;

use App\Telegram\CallBacks\GetChat;
use App\Telegram\CallBacks\HandleChatMessage;
use App\Telegram\CallBacks\Home\Home;
use App\Telegram\CallBacks\Start;
use App\Telegram\CallBacks\TelegramHandler;
use Illuminate\Support\Stringable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class TelegramWebHookHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    use Start;
    use HandleChatMessage;
    use message;
    use GetChat;

    //Home
    use Home;

    protected array $routes;

    public function __construct()
    {
        parent::__construct();

        $this->routes = [
            "home" => [
                'context' => 'Home',
                'fun' => 'goToHome'
            ],
            "Account" => ['fun' => 'viewAccount'],
            "Balance" => ['fun' => 'checkBalance'],
            "Leaders Board" => ['fun' => 'goToLeadersBoard'],
            "About" => ['fun' => 'goToAbout'],
            "FAQ" => ['fun' => 'viewFAQ'],
        ];
    }

    /**
     * @throws \Throwable
     */
    public function handleChatMessage(Stringable $text = null): void
    {
        if (empty($this->getChat()->storage()->get('app_context'))) {

            foreach ($this->routes as $key => $route) {
                //no context set
                if (strcasecmp($key, $text) === 0) {
                    //set ap context
                    $this->getChat()->storage()->set('app_context', $text);

                    //get executable
                    $function = $route['fun'];
                    if (method_exists($this, $function)) {
                        $this->$function($text);
                        break;
                    }
                } else {
                    //context is set
                    $this->getChat()->message("App context is set")->send();
                }
            }
        } else {
            $app_context = $this->getChat()->storage()->get('app_context');


            switch ($app_context) {
                case 'Home':
                    $this->goToHome($text);
                    break;
                default;
                    $this->getChat()->message("app context is unknown")->send();
                    break;

            }
        }
    }


    public function invalid_phone_number_action(): void
    {
        $this->msg("action-cancel");
        //enquire to continue
//        $action = $this->data->get('action');
//
//        if ($action == 'Try Again') {
//            $this->select_plan();
//        } else {
//            $this?->getChat()
//                ->message("Home")
//                ->send();
//        }
    }


    /**
     * @throws \Throwable
     */
    protected function onFailure(\Throwable $throwable): void
    {
        if ($throwable instanceof NotFoundHttpException) {
            throw $throwable;
        }

        report($throwable);

        $this->reply('Option not available');
    }
}


