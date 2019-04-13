<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChannelReduce extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $fillable=['channel_id','channel_code','channel_name','platform','distribute_template_id','distribute_template_name','distribute_page_id','distribute_page_name','reduce_type','reduce_rate','modifier_id','modifier_name'];

    public function channel(){

        return $this->belongsTo(Channel::class,'channel_code','channel_code');
    }

    public function template(){

        return $this->belongsTo(DistributeTemplate::class,'distribute_template_id','id');
    }

    public function page(){

        return $this->belongsTo(DistributePage::class,'distribute_page_id','id');
    }

    public function reduceRecord(){

        return $this->hasMany(ReduceRecord::class,'channel_reduce_id','id');
    }
}
