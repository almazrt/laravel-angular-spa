<?php

namespace App\Http\Controllers\my;

use App\Http\Controllers\Controller;
use App\Libs\Telegram;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function request(Request $request)
    {
        Telegram::sendMessage(env('TELEGRAM_ADMIN_CHAT_ID', 3153143), '/user' . \Auth::id() . ' ' . $request->subject);
        Telegram::sendContact(env('TELEGRAM_ADMIN_CHAT_ID', 3153143), preg_replace('/[^0-9\+]/', '', $request->whatsapp), \Auth::user()->name);
    }

}
