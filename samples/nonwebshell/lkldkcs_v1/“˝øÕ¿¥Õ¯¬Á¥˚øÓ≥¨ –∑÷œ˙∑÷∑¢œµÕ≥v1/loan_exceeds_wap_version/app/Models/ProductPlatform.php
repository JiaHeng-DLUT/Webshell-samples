<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPlatform extends Model
{

    protected $table='product_has_platforms';

    protected $fillable=['product_id','platform'];

    public function product(){

        return $this->belongsTo(Product::class,'product_id','id');
    }
}
