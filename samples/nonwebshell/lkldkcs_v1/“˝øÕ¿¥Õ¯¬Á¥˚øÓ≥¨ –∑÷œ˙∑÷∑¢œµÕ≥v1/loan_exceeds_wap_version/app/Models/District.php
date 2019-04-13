<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';
    protected $guarded = [];

    public function child(){

        return $this->hasMany(District::class,'parent_id','id');
    }

    public function parent(){

        return $this->belongsTo(District::class,'parent_id','id');
    }

    //城市产品
    public function productCity()
    {
        return $this->belongsToMany(Product::class,'product_has_districts','district_id','product_id');
    }
}
