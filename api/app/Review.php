<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    const STATUS_NEW = 1;
    const STATUS_MODERATING = 2;
    const STATUS_ACTIVE = 3;
    const STATUS_REJECTED = 4;
    const STATUS_BLOCKED = 5;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_user_id');
    }

    protected $fillable = [
        'user_id', 'reviewer_user_id', 'value', 'description', 'status'
    ];

}
