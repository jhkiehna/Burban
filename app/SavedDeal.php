<?php

namespace App;

use App\User;
use App\Deal;
use Illuminate\Database\Eloquent\Model;

class SavedDeal extends Model
{
    protected $table = 'saved_deals';

    protected $fillable = [
        'user_id',
        'deal_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class, 'deal_id');
    }
}
