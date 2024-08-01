<?php

namespace App\Http\Controllers;

use App\Models\User;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Random\RandomException;

class AccountController extends Controller
{
    public TelegraphChat $chat;

    public function account(TelegraphChat $TelegraphChatID): \Inertia\Response
    {
        $this->chat = $TelegraphChatID;
        $user = User::where('telegram_id', $this->chat->id)->first();

        if (is_null($user->password)) {
            $password_reset = DB::table('password_resets')->where('userid', $user->id)->first();
            $code = $this->generate_code();

            if (is_null($password_reset)) {

                DB::table('password_resets')->insert([
                    'userid' => $user->id,
                    'code' => $code,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

            } else {
                DB::table('password_resets')
                    ->where('userId', $user->id)
                    ->update([
                        'code' => $code,
                        'updated_at' => now()
                    ]);
            }

            $this->chat->message("Code:" . $code)->send();


            return Inertia::render('Telegram/Account/AccountSetup', [
                "user" => $user->id,
            ]);
        } else {
            $name = $this->chat->name;
            $username = str_replace(["[private] ", "[public] "], "", $name);

            return Inertia::render('Telegram/Account/AccountAccess', [
                'username' => $username,
            ]);
        }
    }

    public function register_administrator(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
//            'phone' => 'required|string|min:10|max:10|unique:users',
            'password' => 'required|string|min:6|max:255|confirmed',
        ]);

        $user = new User();
        $user->name = $validated['username'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);

        $user->save();

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }

    public function get_all_users()
    {
        $users = User::orderBy('id', 'desc')->get();
        $users = $users->transform(function ($user) {
            $username = null;
            $mode = null;

            if (is_null($user->telegram_id)) {
                $username = $user->name;
                $mode = "localised";
            } else {
                $username = TelegraphChat::find($user->telegram_id);

                if (!is_null($username)) {
                    $username = $this->removePrivateTag($username->name);
                    $mode = "telegram";
                } else {
                    $username = null;
                    $mode = "undefined";
                }
            }

            return [
                'id' => $user->id,
                'username' => $username,
                'mode' => $mode,
                'Balance' => $user->balance,
                'subscription' => $user->active_subscription,
            ];
        });

        return Inertia::render('Application/Users/index', [
            'users' => $users,
        ]);
    }

    function removePrivateTag($input)
    {
        $privateTag = '[private]';

        if (substr($input, 0, strlen($privateTag)) === $privateTag) {
            return substr($input, strlen($privateTag));
        }

        return $input;
    }

    /**
     * @throws RandomException
     */
    private function generate_code(): int
    {
        return random_int(100000, 999999);
    }
}
