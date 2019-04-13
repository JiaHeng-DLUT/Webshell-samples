<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{

    protected $fillable=['name','sort','icon','banner','banner_redirect','redirect_type','redirect_slug','redirect_id','pc_banner'];

    //
    public function product(){

        return $this->belongsToMany(Product::class,'product_has_categories','category_id','product_id');
    }
//专题产品
    public function categoryProduct()
    {
        return $this->belongsToMany(Product::class,'product_has_categories','category_id','product_id');
    }

}
