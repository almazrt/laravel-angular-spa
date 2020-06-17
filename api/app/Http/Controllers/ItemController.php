<?php

namespace App\Http\Controllers;

use App\Category;
use App\ContactsRequest;
use App\Item;
use App\Review;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function contacts(Item $item)
    {
        if ($item->user_id != Auth::id()) {
            if (Auth::user()->contacts_can_view_count < Auth::user()->contactRequests()->count()) return response(['message' => 'Чтобы смотреть контакты, вам нужно приобрести подписку.', 'newUrl' => '/my/services'], 400);
            ContactsRequest::firstOrCreate(['user_id' => Auth::id(), 'item_id' => $item->id]);
        }

        return Item::where('id', $item->id)
            ->active()
            ->select(['phone', 'whatsapp', 'insta', 'telegram', 'vk', 'fb', 'website', 'address', 'other_contacts'])
            ->first();
    }

    public function show($id)
    {
        return Item::where('id', $id)
            ->active()
            ->select(['id', 'user_id', 'category_id', 'title', 'description', 'city_id'])
            ->with('category')
            ->with('city')
            ->with(['user' => function (BelongsTo $query) {
                $query->select('id', 'name', 'rating');
            }])
            ->with(['reviews' => function (HasMany $query) {
                $query->where('status', Review::STATUS_ACTIVE);
                $query->orderBy('created_at', 'desc');
                $query->with('reviewer');
            }])
            ->first();
    }

    public function index(Request $request)
    {
        $items = Item::active();

        $items->select([
            'items.id',
            'items.user_id',
            'items.category_id',
            'items.title',
            'items.description',
            'items.city_id',
            'users.name as user_name',
            'users.rating as user_rating'
        ]);

        $items->leftJoin('users', 'items.user_id', '=', 'users.id');
        $items->whereIn('users.status', [User::STATUS_NEW, User::STATUS_ACTIVE, User::STATUS_MODERATING]);

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

        return $items->with('city')
            ->with(['reviews' => function (HasMany $query) {
                $query->where('status', Review::STATUS_ACTIVE);
                $query->limit(1);
                $query->orderBy('created_at', 'desc');
            }])
            ->orderBy('users.rating', 'desc')
            ->paginate(10);
    }

}
