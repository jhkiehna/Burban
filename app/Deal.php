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
        'start_date',
        'end_date',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
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
        SavedDeal::where('deal_id', $this->id)->delete();

        parent::delete();
    }
}
