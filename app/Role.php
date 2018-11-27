<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Role
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[] $permissions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role query()
 * @mixin \Eloquent
 */
class Role extends Model
{
    protected $fillable = ['name','display_name','description'];

    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }

    public function assignPermission($permission){
        if(is_int($permission)){
            $permission = Permission::findOrFail($permission);
        }else if(is_string($permission)){
            $permission = Permission::whereName($permission)->first();
        }
        return $this->permissions()->save($permission);
    }
}
