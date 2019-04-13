<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannelCeiling extends Model
{
    protected $fillable=['ceiling_num','channel_code','user_id'];
    //
    public function channel(){

        return $this->belongsTo(Channel::class,'channel_code','channel_code');
    }
}
