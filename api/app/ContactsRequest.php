<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactsRequest extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    protected $fillable = [
        'user_id', 'item_id', 'status'
    ];
}
