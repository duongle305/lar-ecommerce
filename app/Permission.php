<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Permission
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission query()
 * @mixin \Eloquent
 */
class Permission extends Model
{
    protected $fillable = ['name','display_name','description'];

    public function roles(){
        return $this->belongsToMany(Role::class);
    }
}
