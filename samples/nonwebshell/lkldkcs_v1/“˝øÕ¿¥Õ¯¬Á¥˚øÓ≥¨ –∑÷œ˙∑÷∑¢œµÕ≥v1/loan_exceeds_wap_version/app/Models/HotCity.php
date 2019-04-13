<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotCity extends Model
{

    protected $fillable=['city_id','sort'];

    public function city(){

        return $this->hasOne(District::class,'id','city_id');
    }
}
