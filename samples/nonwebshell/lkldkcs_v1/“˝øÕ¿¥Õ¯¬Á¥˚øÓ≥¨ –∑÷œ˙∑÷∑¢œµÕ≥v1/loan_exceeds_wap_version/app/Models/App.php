<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $fillable=['name','package_name','application_id','logo','download_url','qrcode_url','platform','version','update_log','channel_id','channel_code','status'];

    public function application(){

        return $this->belongsTo(Application::class,'application_id','id');
    }

    public function channel(){

        return $this->belongsTo(Channel::class,'channel_code','channel_code');
    }
}
