<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = [
        'title',
        'description',
    ];

    public function business()
    {
        return $this->belongsTo(Deal::class);
    }
}
