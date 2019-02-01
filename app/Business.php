<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    public function deals()
    {
        return $this->hasMany(Deal::class);
    }
}
