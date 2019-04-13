<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppStartup extends Model
{
    protected $guarded = [];
    public function app(){

        return $this->belongsTo(App::class,'app_id','id');
    }

    public function device(){

        return $this->belongsTo(Device::class,'identifier','identifier');
    }
}
