<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($id)
    {
        return Category::find($id);
//        return Category::where('id', $id)
//            ->with(['children' => function (HasMany $query) {
//                $query->with('children');
//            }])
//            ->get();
    }

    public function index(Request $request)
    {
        return Category::where('parent_id', Category::ID_MAIN)
            ->with('children')
            ->orderBy('sort')
            ->orderBy('name')
            ->get();
    }

}
