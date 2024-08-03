<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

Route::post('/setupAccount', function (Request $request) {
    // Define the validation rules
    $validator = Validator::make($request->all(), [
        'user' => 'required|integer|exists:users,id', // assuming user IDs are integers and exist in the users table
        'code' => 'required|string|size:6', // assuming the code is always a 6-character string
        'password' => 'required|string|min:8|confirmed', // password must be confirmed and at least 8 characters long
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    // Proceed with the existing logic
    $password_reset = DB::table('password_resets')->where('userid', $request->input('user'))->first();

    if (!$password_reset) {
        return response()->json(['error' => 'Invalid user or code.'], 404);
    }

    $code = $password_reset->code;

    // Assuming you want to check if the code matches
    if ($request->input('code') !== $code) {
        return response()->json(['error' => 'Invalid code.'], 400);
    }

    // Proceed with password update logic
    // Assuming you have a User model and want to update the password
    $user = \App\Models\User::find($request->input('user'));
    $user->password = bcrypt($request->input('password'));
    $user->save();

    // Delete the password reset record
    DB::table('password_resets')->where('userid', $request->input('user'))->delete();

    return redirect(route('account', ['TelegraphChatID' => $user->telegram_id]));
})->name('setupAccount');


Route::post('/authorizeUser', function (Request $request) {
    // Define the validation rules
    $validator = Validator::make($request->all(), [
        'user' => 'required|int|exists:users,id',
        'password' => 'required|string',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    // Retrieve the user based on the provided ID
    $user = User::find($request->input('user'));

    // Compare the provided password with the stored password
    if (Hash::check($request->input('password'), $user->password)) {
// Passwords match, create a token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Manually log in the user
        Auth::login($user);

        return response()->json([
            'message' => 'User authorized successfully.',
            'user' => $user,
            'token' => $token
        ], 200);

    } else {
        // Passwords do not match
        return response()->json([
            'errors' => ['password' => ['The provided password is incorrect.']]
        ], 401);
    }
})
    ->name('authorizeUser');


Route::get('/profile', function (Request $request) {
    $user = Auth::user();

    return Inertia::render('Telegram/Account/Account', [
        'user' => $user
    ]);
})
    ->middleware(['auth:sanctum'])
    ->name('profile');
