<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable=['user_id','role_id','channel_name','channel_code','department_id','manager','reduce_type','redirect_status','ceiling_num','status','deal_at'];

    public function department(){

        return $this->belongsTo(Department::class,'department_id','id');
    }

    public function user(){

        return $this->hasOne(User::class,'id','user_id');
    }

    public function role(){

        return $this->hasOne(Role::class,'id','role_id');
    }

    public function ceilRecord(){

        return $this->hasMany(ChannelCeiling::class,'channel_code','channel_code');
    }

    public function page(){

        return $this->hasMany(DistributePage::class,'channel_code','channel_code');
    }
    public function dealRecord(){

        return $this->hasMany(DealRecord::class,'channel_code','channel_code');
    }




    public function scopeGetChannel($query,$id)
    {
        return $query->select('id','channel_name','channel_code')->where(['department_id'=>$id,'status'=>1])->groupBy('channel_name')->get();
    }


    public function newLabel(){

        return $this->belongsToMany(Label::class,'label_has_channels','channel_id','label_id');
    }


}
