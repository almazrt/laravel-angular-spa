<?php

namespace App\Http\Controllers\my;

use App\Category;
use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function destroy($id)
    {
        return Item::where('id', $id)
            ->where('user_id', \Auth::user()->id)
            ->delete();
    }

    public function show($id)
    {
        return Item::where('id', $id)
            ->select(Item::getFillableColumns())
            ->where('user_id', \Auth::user()->id)
            ->with('category')
            ->with('city')
            ->with(['user' => function (BelongsTo $query) {
                $query->select('id', 'name', 'rating');
            }])->first();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'city_id' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'phone' => 'required_without:whatsapp',
            'whatsapp' => 'required_without:phone',
        ]);

        $request->merge([
            'status' => Item::STATUS_NEW,
            'user_id' => \Auth::user()->id,
        ]);

        return $request->input('id') ?
            Item::where('id', $request->input('id'))->update($request->only(Item::getFillableColumns())) :
            Item::create($request->all());
    }

    public function index(Request $request)
    {
        $items = Item::where('user_id', \Auth::user()->id);

        if ($request->has('categoryId') && $category = Category::find($request->categoryId)) {
            $items->whereIn('category_id', $category->selfAndChildrenIds());
        }

        if ($request->has('cityId')) {
            $items->where('city_id', $request->input('cityId'));
        }

        if ($request->has('userId')) {
            $items->where('user_id', $request->input('userId'));
        }

        if ($request->has('term')) {
            $items->where('title', 'like', '%' . $request->input('term') . '%');
        }

        return $items->with(['user' => function (BelongsTo $query) {
            $query->select('id', 'name', 'rating');
            $query->orderBy('rating', 'desc');
        }])->with('city')
            ->with('category')
            ->paginate(5);
    }

}
