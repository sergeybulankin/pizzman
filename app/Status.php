<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Status extends Model
{
    protected $table = 'statuses';

    protected $appends = [
        'created_utc',
        'updated_utc',
    ];

    protected $dates = [
        'created_utc',
        'updated_utc',
    ];

    /**
     * @return static
     */
    public function getCreatedUtcAttribute()
    {
        $timeZone = 'Asia/Yekaterinburg';

        return Date::createFromFormat('Y-m-d H:i:s', $this->getOriginal('created_at'))->timezone($timeZone);
    }

    /**
     * @return static
     */
    public function getUpdatedUtcAttribute()
    {
        $timeZone = 'Asia/Yekaterinburg';

        return Date::createFromFormat('Y-m-d H:i:s', $this->getOriginal('updated_at'))->timezone($timeZone);
    }
}
