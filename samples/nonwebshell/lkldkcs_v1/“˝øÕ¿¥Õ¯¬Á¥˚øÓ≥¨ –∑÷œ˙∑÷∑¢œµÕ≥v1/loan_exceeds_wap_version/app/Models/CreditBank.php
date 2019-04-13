<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditBank extends Model
{

    protected $fillable=['name','sort'];
    //
    public function credit(){

        return $this->hasMany(Credit::class,'credit_bank_id','id');
    }
}
