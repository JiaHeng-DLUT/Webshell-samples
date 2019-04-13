<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperateLog extends Model
{
    protected $fillable=['user_id','path','method','ip','input'];

    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }
}
