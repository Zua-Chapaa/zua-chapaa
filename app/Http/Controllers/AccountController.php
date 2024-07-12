<?php

namespace App\Http\Controllers;

use App\Models\User;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AccountController extends Controller
{
    public TelegraphChat $chat;

    public function account(TelegraphChat $TelegraphChatID): \Inertia\Response
    {
        $this->chat = $TelegraphChatID;

        $name = $this->chat->name;
        $username = str_replace(["[private] ", "[public] "], "", $name);

        return Inertia::render('Telegram/Account', [
            'username' => $username,
        ]);
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
}
