<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Customer
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer query()
 * @mixin \Eloquent
 */
class Customer extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $fillable = [
        'name',
        'email',
        'address',
        'another_address',
        'phone',
        'state',
        'birthday',
        'avatar',
        'company',
        'gender',
        'country',
        'zip_code'];

    protected $hidden = ['password','remember_token'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
