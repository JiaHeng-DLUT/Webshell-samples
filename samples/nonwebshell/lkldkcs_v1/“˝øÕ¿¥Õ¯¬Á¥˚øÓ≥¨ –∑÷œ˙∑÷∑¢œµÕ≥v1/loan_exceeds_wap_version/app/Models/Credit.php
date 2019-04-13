<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    //
    protected $guarded = [];

    public function bank(){

        return $this->hasOne(CreditBank::class,'id','credit_bank_id');
    }

    public function corner(){

        return $this->hasOne(Corner::class,'id','corner_id');
    }

    public function level(){

        return $this->hasOne(CreditLevel::class,'id','credit_level_id');
    }

    public function organization(){

        return $this->hasOne(CreditOrganization::class,'id','credit_organization_id');
    }

    public function apply(){
        return $this->hasMany(Apply::class,'credit_id','id');
    }


    public function countApplyCounts($id){
        return $this->apply()
            ->where('credit_id',$id)
            ->get()
            ->count();
    }
    /**
     *类型过滤
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    //信用卡评价
    public function creditComment()
    {
        return $this->hasOne(Comment::class,'credit_id','id');
    }



}
