<?php

namespace App;

use App\Deal;
use App\Business;
use App\SavedDeal;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'email', 'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function isBusinessUser()
    {
        return $this->business_user;
    }

    public function makeBusinessUser()
    {
        $this->business_user = true;
        $this->save();
    }

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
