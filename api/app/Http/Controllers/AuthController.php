<?php

namespace App\Http\Controllers;

use App\Category;
use App\Libs\Smsc;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $request->merge(['phone' => preg_replace('/\D/', '', $request->phone)]);

        $request->validate([
            'phone' => 'required|string|digits:10',
        ]);

        if (!$user = User::where('phone', $request->input('phone'))->first()) {
            $user = User::create(['phone' => $request->input('phone'), 'rating' => 0, 'status' => User::STATUS_NEW]);
            $user->name = 'User' . $user->id;
        }

        $user->verification_token = rand(111111, 999999);
        $user->save();
        Smsc::sendSms('+7' . $user->phone, $user->verification_token);

        return ['userId' => $user->id];
    }

    public function confirm(Request $request)
    {
        if ($user = User::find($request->input('userId'))) {
            if ($user->verification_token == $request->input('code')) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                return response(['token' => $token, 'user' => $user], 200);
            } else {
                return response(['message' => 'Не правильный код подтверждения'], 400);
            }
        }
    }

    public function autologin(Request $request)
    {
        if ($user = User::where('verification_token', $request->input('token'))->first()) {
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            return response(['token' => $token, 'user' => $user], 200);
        } else {
            return response(['message' => 'Не правильный код подтверждения'], 400);
        }
    }


}
