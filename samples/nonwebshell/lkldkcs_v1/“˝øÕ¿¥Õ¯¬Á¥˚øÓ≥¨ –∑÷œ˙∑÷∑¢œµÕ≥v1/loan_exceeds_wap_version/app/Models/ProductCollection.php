<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCollection extends Model
{
    //
    protected $guarded = [];
    public function member(){

        return $this->belongsTo(Member::class,'mid','id');
    }

    public function product(){

        return $this->belongsTo(Product::class,'product_id','id');
    }
}
