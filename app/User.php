<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'wallet',
        'pub_key',
    ];

    protected $with = ['kyc'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Add kycs to user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kyc()
    {
        return $this->hasOne(\App\UserKyc::class);
    }


    /**
     * Add employees to user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees()
    {
        return $this->hasMany(\App\UserEmployee::class);
    }
}
