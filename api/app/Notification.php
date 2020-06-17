<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    const STATUS_NEW = 1;
    const STATUS_NOTIFIED = 2;
    const STATUS_READ = 3;

    const TYPE_INFO = 1;
    const TYPE_SUCCESS = 2;
    const TYPE_ERROR = 3;

}
