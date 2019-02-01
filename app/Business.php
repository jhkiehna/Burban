<?php

namespace App;

use App\Deal;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }
}
