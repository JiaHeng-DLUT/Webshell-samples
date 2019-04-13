<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    //
    protected $guarded = [];
    public function app(){

        return $this->hasMany(App::class,'application_id','id');
    }
}
