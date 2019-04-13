<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealInformation extends Model
{
    protected $guarded = [];

    protected $casts=[
        'info'=>'json'
    ];

    public function member()
    {
        return $this->hasOne(Member::class,'id','mid');
    }
    public function provinceName()
    {
        return $this->hasOne(District::class,'id','province');
    }
    public function cityName()
    {
        return $this->hasOne(District::class,'id','city');
    }
    public function districtName()
    {
        return $this->hasOne(District::class,'id','district');
    }
}
