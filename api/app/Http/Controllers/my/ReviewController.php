<?php

namespace App\Http\Controllers\my;

use App\Http\Controllers\Controller;
use App\Item;
use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Item $item, Request $request)
    {
        $request->merge([
            'status' => Review::STATUS_NEW,
        ]);
        return Review::create($request->all());
    }

}
