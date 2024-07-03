<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Http\Controllers;

use App\Http\Generators\MpesaGenerators;
use App\Models\Order;
use App\Models\User;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Http\Request;
use Illuminate\Support\Stringable;

class MpesaController extends Controller
{
    use MpesaGenerators;

    public function sendRequest(TelegraphChat $chat, Stringable $text): void
    {
//        //get authorisation key
//        $encoded_string = $this->basicAuthorisation($chat);
//
//        //decode response
//        $response = json_decode($this->getAuthorisation($encoded_string));
//
//        //get access token
//        $access_token = $response->access_token;
//
//        //Send request
//        $response = $this->makePaymentRequest($access_token, $chat, $text);
//
//        //decode response
//        $response_parsed = json_decode($response);

        //make an order matching request
        $user = User::where('telegram_id', $chat->id)->first();
        $order = new Order();

        $order->user_id = $user->id;
        $order->telegram_chat_id = $chat->id;
        $order->amount = $chat->storage()->get('plan') == 'hourly' ? 1 : 2;

        $order->save();

        $chat->message("created order")->send();

    }


    public function getAuthorisation($encoded_string): string|bool
    {
        $ch = curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . $encoded_string
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function makePaymentRequest($access_token, TelegraphChat $chat, Stringable $text): bool|string
    {
        $make_values = $this->data_generator($chat, $text);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                                   "BusinessShortCode": "' . env('BUSINESS_SHORT_CODE') . '",
                                   "Password": "' . $make_values["encoded_string"] . '",
                                   "Timestamp":"' . $make_values["timestamp"] . '",
                                   "TransactionType": "CustomerPayBillOnline",
                                   "Amount": "' . $make_values['amount'] . '",
                                   "PartyA":"' . $text . '",
                                   "PartyB":"' . env('BUSINESS_SHORT_CODE') . '",
                                   "PhoneNumber":"' . $text . '",
                                   "CallBackURL": "https://zuachapaa.tipsmoto.co.ke/mpesa/callback",
                                   "AccountReference":"Shikisha Kakitu LTD",
                                   "TransactionDesc":"Payment for ' . $text . ' Subscription"
                                }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $access_token,
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function mpesa_callback(Request $request, $by_pass = false): void
    {
        $chat = TelegraphChat::where("id", 1)->first();
        $order = Order::where('telegram_chat_id', $chat->id)
            ->where('status', 'pending')
            ->first();

        if ($order) {
            $order->status = 'paid';
            $user = User::where('telegram_id', $chat->id)->first();

            $user->active_subscription = $order->amount == 1 ? "Hourly" : "Daily";

            $order->save();
            $user->save();

            //reset user context
            $chat->storage()->set('app_context', "");
        }
    }
}
