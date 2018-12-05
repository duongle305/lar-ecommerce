<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Customer
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Customer query()
 * @mixin \Eloquent
 */
class Customer extends Model
{
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
}
