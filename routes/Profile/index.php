<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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

    return response()->json(['message' => 'Password updated successfully.']);
})->name('setupAccount');
