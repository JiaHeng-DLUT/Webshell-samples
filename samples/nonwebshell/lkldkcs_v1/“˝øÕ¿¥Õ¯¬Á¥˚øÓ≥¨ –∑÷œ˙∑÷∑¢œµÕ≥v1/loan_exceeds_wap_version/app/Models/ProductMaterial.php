<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMaterial extends Model
{
    //
    protected $fillable=['name','sort','created_at','updated_at'];


    public function product(){

        return $this->belongsToMany(ProductMaterial::class,'product_has_materials','product_id','material_id');
    }
}
