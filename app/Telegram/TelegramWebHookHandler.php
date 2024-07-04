<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Telegram;

use App\Http\Controllers\MpesaController;
use App\Telegram\CallBacks\GetChat;
use App\Telegram\CallBacks\HandleChatMessage;
use App\Telegram\CallBacks\Home\Home;
use App\Telegram\CallBacks\Start;
use App\Telegram\CallBacks\TelegramHandler;
use DefStudio\Telegraph\Models\TelegraphBot;
use Illuminate\Http\Request;
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

    public function __construct(MpesaController $m_pesa_controller)
    {
        parent::__construct();
        $this->setMpesaController($m_pesa_controller);

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
    public function handleChatMessage($text = null): void
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

    /**
     * @throws \Throwable
     */
    public function handle(Request $request, TelegraphBot $bot): void
    {
        parent::handle($request, $bot);
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


