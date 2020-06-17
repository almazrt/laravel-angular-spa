<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use phpDocumentor\Reflection\Types\Self_;

class Item extends Model
{
    use SoftDeletes;

    const STATUS_NEW = 1;
    const STATUS_MODERATING = 2;
    const STATUS_ACTIVE = 3;
    const STATUS_REJECTED = 4;
    const STATUS_BLOCKED = 5;

    const STATUS_NAMES = [
        self::STATUS_NEW => 'Новый',
        self::STATUS_MODERATING => 'На проверке',
        self::STATUS_ACTIVE => 'Активный',
        self::STATUS_REJECTED => 'Отклонен',
        self::STATUS_BLOCKED => 'Заблокирован',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'id', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive(Builder $query)
    {
        return $query->whereNull('items.deleted_at')->where('items.status', self::STATUS_ACTIVE);
    }

    public function scopeNew(Builder $query)
    {
        return $query->whereNull('items.deleted_at')->where('items.status', self::STATUS_NEW);
    }

    protected $fillable = [
        'id', 'user_id', 'category_id', 'title', 'description', 'phone', 'whatsapp', 'insta', 'telegram', 'vk', 'fb', 'website', 'address', 'other_contacts', 'status', 'deleted_at', 'city_id'
    ];

    public static function getFillableColumns()
    {
        return (new self())->fillable;
    }
}
