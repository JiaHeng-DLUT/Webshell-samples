<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apply extends Model
{
    protected $guarded = [];
    public function product(){

        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function credit(){

        return $this->belongsTo(Credit::class,'credit_id','id');

    }

    public function channel(){

        return $this->belongsTo(Channel::class,'channel_code','channel_code');
    }

    public function registerPage(){

        return $this->belongsTo(DistributePage::class,'register_page_id','id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class,'mid','id');
    }

    //申请产品
    public function productIntention(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    //申请信用卡
    public function creditIntention()
    {
        return $this->hasOne(Credit::class,'id','credit_id');
    }
}
