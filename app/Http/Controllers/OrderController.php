<?php

namespace App\Http\Controllers;

use App\Models\Order;
use DefStudio\Telegraph\Models\TelegraphChat;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function List_all_orders()
    {
        $orders = Order::all();

        $orders = $orders->transform(function ($order) {
            $username = null;

            $user = TelegraphChat::find($order->telegram_chat_id);

            if (!is_null($user)) {
                $username = (new AccountController())->removePrivateTag($user->name);
            }

            return [
                'id' => $order->id,
                'username' => $username,
                'amount' => $order->amount,
                'status' => $order->status,
            ];
        });

        return Inertia::render('Application/Transactions/index', [
            'orders' => $orders
        ]);
    }
}
