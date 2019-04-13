<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColumn extends Model
{

    protected $fillable=['name','sort','banners'];

    //
    public function product(){

        return $this->belongsToMany(ProductCategory::class,'product_has_columns','column_id','product_id');
    }

    //栏目产品
    public function columnProduct()
    {
        return $this->belongsToMany(Product::class,'product_has_columns','column_id','product_id');
//        return $this->hasMany(Product::class,'column_id','product_id');
    }
}
