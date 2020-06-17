<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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

    public function contactRequests()
    {
        return $this->hasMany(ContactsRequest::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'status', 'rating'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
