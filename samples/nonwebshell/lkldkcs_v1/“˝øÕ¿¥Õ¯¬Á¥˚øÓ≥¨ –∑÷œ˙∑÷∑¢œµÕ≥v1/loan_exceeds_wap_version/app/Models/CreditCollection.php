<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditCollection extends Model
{
    protected $guarded = [];
    //
    public function credit(){

        return $this->belongsTo(Credit::class,'credit_id','id');
    }

    public function member(){

        return $this->belongsTo(Member::class,'mid','id');
    }
}
