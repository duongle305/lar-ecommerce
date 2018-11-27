<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Province
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\District[] $district
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Province query()
 * @mixin \Eloquent
 */
class Province extends Model
{
    protected $table='provinces';
    protected $fillable=['id','name','slug_name','type',''];

    public function district(){
        return $this->hasMany('App\District');
    }
}
