<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditOrganization extends Model
{

    protected $fillable=['name','sort'];
    protected  $guarded = [];
    //
    public function credit(){

        return $this->hasMany(Credit::class,'credit_organization_id','id');
    }
}
