<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
