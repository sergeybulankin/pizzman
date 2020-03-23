<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class OrderStatus extends Model
{
    protected $table = 'orders_statuses';

    protected $appends = [
        'created_utc'
    ];

    protected $dates = [
        'created_utc'
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
