<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','slug','parent_id','note','order'];
    protected $hidden = ['created_at','updated_at'];

    public function parent()
    {
        return $this->belongsTo('App\Category');
    }

    public function children()
    {
        return $this->hasMany('App\Category','parent_id');
    }
    public function tree()
    {
        return $this->where('parent_id',NULL)
            ->with(['children'])
            ->orderBy('orders')
            ->get(['id','name','slug','note']);
    }
}
