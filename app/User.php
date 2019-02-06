<?php

namespace App;

use App\Deal;
use App\Business;
use App\SavedDeal;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function business()
    {
        return $this->hasOne(Business::class);
    }

    public function savedDeals()
    {
        return $this->hasMany(SavedDeal::class);
    }

    public function generateApiToken()
    {
        do {
            $this->api_token = str_random(60);
        } while ($this->where('api_token', $this->api_token)->exists());
        
        $this->save();
    }

    public function authenticate($password)
    {
        if (Hash::check($password, $this->password)) {
            $this->generateApiToken();
            return true;    
        }
        
        return false;
    }
}
