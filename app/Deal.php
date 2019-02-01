<?php

namespace App;

use App\Business;
use App\SavedDeal;
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

    public function savedDeals()
    {
        return $this->hasMany(SavedDeal::class);
    }

    public static function forUser($user)
    {
        return self::whereHas('savedDeals', function($query) use ($user){
            $query->where('user_id', $user->id);
        });
    }
}
