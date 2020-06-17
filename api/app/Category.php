<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const ID_MAIN = 125;

    const STATUS_ACTIVE = 1;
    const STATUS_MAIN = 2;
    const STATUS_INACTIVE = 3;

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function scopeSelfAndChildrenIds(Builder $query)
    {
        return array_merge([$this->id], $this->children()->pluck('id')->toArray());
    }

}
