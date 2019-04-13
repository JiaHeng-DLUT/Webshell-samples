<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $guarded = [];

    public function channel(){

        return $this->belongsToMany(Channel::class,'label_has_channels','label_id','channel_id');
    }

    public function product(){

        return $this->belongsToMany(Channel::class,'label_has_products','label_id','product_id');
    }
}
