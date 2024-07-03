<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Http\Controllers;

use App\Http\Generators\MpesaGenerators;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Stringable;

class MpesaController extends Controller
{
    use MpesaGenerators;

    public function sendRequest(TelegraphChat $chat, Stringable $text): void
    {
        $encoded_string = $this->basicAuthorisation($chat);
        $response = json_decode($this->getAuthorisation($encoded_string));
        $access_token = $response->access_token;

//        $chat->message($text)->send();

        $response = $this->makePaymentRequest($access_token, $chat, $text);

//        $chat->message($response)->send();
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
                            "Password": "' . $make_values["encoded_string"] . ' ",
                            "Timestamp": "' . $make_values["timestamp"] . '",
                            "TransactionType": "CustomerPayBillOnline",
                            "Amount": "' . $make_values['amount'] . '",
                            "PartyA": "' . $text . '",
                            "PartyB": "' . env('BUSINESS_SHORT_CODE') . '",
                            "PhoneNumber": "' . $text . '",
                            "CallBackURL": "http://zuachapaa.tipsmoto.co.ke/mpesa/callback",
                            "AccountReference": " ",
                            "TransactionDesc": " "
                        }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $access_token,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function mpesa_callback(Request $request): void
    {
        Log::info($request);
    }
}
