<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealRecord extends Model
{
    protected $fillable=['channel_code','user_id','deal_at'];
    //
    public function channel(){

        return $this->belongsTo(Channel::class,'channel_code','channel_code');
    }

    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }
}
