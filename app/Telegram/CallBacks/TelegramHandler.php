<?php

namespace App\Telegram\CallBacks;

use Throwable;

trait TelegramHandler
{
    /**
     * @throws Throwable
     */
    protected function onFailure(Throwable $throwable): void
    {
        if ($throwable instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            throw $throwable;
        }

        report($throwable);

        $this->reply('Option not available');
    }

}
