<?php

namespace App;

use App\Deal;
use App\User;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use Searchable;
    
    protected $fillable = [
        'user_id',
        'name',
        'city',
        'state',
        'phone',
        'summary',
    ];
    
    protected $algoliaIndex = 'businesses_index';

    public function serachableAs()
    {
        return $this->algoliaIndex;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    public static function createForUser($userId, $request)
    {
        return self::create([
            'user_id' => $userId,
            'name' => $request->name,
            'city' => $request->city,
            'state' => $request->state,
            'phone' => $request->phone,
            'summary' => $request->summary,
        ]);
    }
}
