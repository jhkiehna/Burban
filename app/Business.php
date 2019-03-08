<?php

namespace App;

use App\Deal;
use App\User;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Services\Geocoder\GoogleGeocoder;

class Business extends Model
{
    use Searchable;
    
    protected $fillable = [
        'user_id',
        'name',
        'street_address',
        'city',
        'state',
        'phone',
        'summary',
    ];

    protected $casts = [
        'coordinates' => 'array',
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
        $business = self::create([
            'user_id' => $userId,
            'name' => $request->name,
            'street_address' => $request->street_address,
            'city' => $request->city,
            'state' => $request->state,
            'phone' => $request->phone,
            'summary' => $request->summary,
        ]);

        $address = $business->street_address . '\n' . $business->city . ', ' . $business->state;

        $business->coordinates = (new GoogleGeocoder())->geocode($address);
        $business->save();

        return $business;
    }
}
