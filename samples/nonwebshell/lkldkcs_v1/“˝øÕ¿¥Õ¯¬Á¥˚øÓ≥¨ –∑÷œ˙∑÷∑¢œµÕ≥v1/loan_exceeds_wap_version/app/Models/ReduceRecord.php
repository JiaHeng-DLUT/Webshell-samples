<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReduceRecord extends Model
{
    protected  $fillable=['channel_reduce_id','reduce_type','reduce_rate','rate_status','effect_start','effect_end','effect_on','mark','before_modify','after_modify','modifier_id','modifier_name'];
    //
    public function reduce(){

        return $this->belongsTo(ReduceRecord::class,'channel_reduce_id','id');
    }
}
