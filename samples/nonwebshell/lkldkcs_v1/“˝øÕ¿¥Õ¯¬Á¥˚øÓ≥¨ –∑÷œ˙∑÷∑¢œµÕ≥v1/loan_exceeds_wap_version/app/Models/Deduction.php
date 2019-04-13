<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    protected $fillable=['channel_code','platform','page_id','phone','mid','reduce_type','deduction_register_id','deduction_apply_id','reduce_rate','status','is_deal'];
    //
    public function channel()
    {

        return $this->belongsTo(Channel::class,'channel_code','channel_code');
    }

    public function member(){

        return $this->hasOne(Member::class,'mid','id');
    }

    public function page(){

        return $this->belongsTo(DistributePage::class,'page_id','id');
    }
}
