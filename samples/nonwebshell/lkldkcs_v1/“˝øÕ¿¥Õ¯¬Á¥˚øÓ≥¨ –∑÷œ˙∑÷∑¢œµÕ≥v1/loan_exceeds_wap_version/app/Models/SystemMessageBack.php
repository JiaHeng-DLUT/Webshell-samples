<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemMessageBack extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function setContentAttribute($content)
    {
        $this->attributes['content'] = str_replace(env('IMG_URL'),'_IMG_',$content);
    }

    public function getContentAttribute($content)
    {
        return str_replace('_IMG_',env('IMG_URL'),$content);
    }

    public function read(){
        return $this->hasMany(SystemMessageClick::class,'system_id','id');
    }
}
