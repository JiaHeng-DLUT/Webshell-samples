<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessApp extends Model
{
    //
    protected $guarded = [];
    public function channel(){

        return $this->belongsTo(Channel::class,'channel_code','channel_code');
    }
}
