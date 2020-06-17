<?php

namespace App\Http\Controllers\my;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show()
    {
        return \Auth::user();
    }

    public function update(Request $request)
    {
        return \Auth::user()->update($request->all());
    }

}
