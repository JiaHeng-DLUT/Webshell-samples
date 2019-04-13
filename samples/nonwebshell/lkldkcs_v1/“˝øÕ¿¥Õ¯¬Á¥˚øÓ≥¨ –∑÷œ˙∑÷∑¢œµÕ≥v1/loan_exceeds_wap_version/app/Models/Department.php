<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name'];


    public function channel(){

        return $this->hasMany(Channel::class,'department_id','id');
    }
}
