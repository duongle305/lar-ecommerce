<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Ward
 *
 * @property-read \App\District $district
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ward newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ward newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ward query()
 * @mixin \Eloquent
 */
class Ward extends Model
{
    protected $table='wards';
    protected $fillable=['id','name','slug_name','type','district_id'];
    public $timestamps=true;

    public function district(){
        return $this->belongsTo('App\District');
    }
}
