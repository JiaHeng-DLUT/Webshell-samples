<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessProduct extends Model
{
    //
    protected $guarded = [];
    public function channel(){

        return $this->belongsTo(Channel::class,'channel_code','channel_code');
    }

    public function product(){

        return $this->belongsTo(Product::class,'product_id','id');
    }
}
