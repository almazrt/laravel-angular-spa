<?php

namespace App\Http\Controllers\my;

use App\Http\Controllers\Controller;
use App\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return Notification::where('user_id', \Auth::user()->id)->paginate(10);
    }

}
