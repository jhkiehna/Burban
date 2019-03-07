<?php

namespace App;

use App\Business;
use App\SavedDeal;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    use Searchable, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
    ];
    
    protected $algoliaIndex = 'deals_index';

    public function serachableAs()
    {
        return $this->algoliaIndex;
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public static function forUser($user)
    {
        return self::whereHas('savedDeals', function($query) use ($user){
            $query->where('user_id', $user->id);
        });
    }

    public function delete()
    {
        $savedDeals = SavedDeal::where('deal_id', $this->id)->delete();

        parent::delete();
    }
}
