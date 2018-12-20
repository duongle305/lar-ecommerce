<?php

namespace App;

use Faker\Provider\Image;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table='product_images';
    protected $fillable=['product_id','path'];
    public $timestamps=true;


    public function name($id){
        $image = ProductImage::find($id);
        $tmp = explode("/",$image->path);
        return $tmp[count($tmp)-1];
    }
}
