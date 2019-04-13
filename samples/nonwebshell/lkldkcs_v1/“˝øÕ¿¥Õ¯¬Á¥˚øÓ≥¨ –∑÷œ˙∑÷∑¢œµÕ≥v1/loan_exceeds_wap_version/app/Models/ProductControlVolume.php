<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductControlVolume extends Model
{
    protected  $fillable = ['uid','product_id','remark','type','created_at','updated_at'];
}
