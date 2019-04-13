<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppMenu extends Model
{
    protected $guarded = [];
    //
    public function app(){

        return $this->belongsTo(App::class,'app_id','id');
    }
}
