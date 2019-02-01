<?php

namespace App;

use App\Business;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = [
        'title',
        'description',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
