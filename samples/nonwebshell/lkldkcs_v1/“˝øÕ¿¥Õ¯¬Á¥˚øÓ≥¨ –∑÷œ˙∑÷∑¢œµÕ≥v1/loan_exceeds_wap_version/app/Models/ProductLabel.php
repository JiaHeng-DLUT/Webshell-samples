<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLabel extends Model
{
    //
    protected $fillable=['name','color','sort','created_at','updated_at'];

    public function product(){

        return $this->belongsToMany(ProductLabel::class,'product_has_labels','label_id','product_id');
    }
}
