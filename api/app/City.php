<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    protected $fillable = ['name'];

}
