<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Additive extends Model
{
    protected $table = 'additives';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function favorite()
    {
        return $this->belongsTo(Favorite::class);
    }
}
