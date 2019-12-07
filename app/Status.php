<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Status extends Model
{
    protected $table = 'statuses';

    /**
     * @param $value
     * @return mixed|string
     */
    public function getUpdatedAtAttribute($value)
    {
        return Date::parse($value)->format('d F H:i');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getCreatedAtAttribute($value)
    {
        return Date::parse($value)->format('d F H:i');
    }
}
