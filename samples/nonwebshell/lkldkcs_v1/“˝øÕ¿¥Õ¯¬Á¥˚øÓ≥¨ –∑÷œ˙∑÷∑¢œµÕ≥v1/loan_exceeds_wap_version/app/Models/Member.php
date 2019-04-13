<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
//use App\Notifications\ResetPasswordNotification;

class Member extends Authenticatable
{
    use Notifiable;
    protected $table = 'members';
    protected $fillable = ['phone','nick','password','avatar','remember_token','uuid'];
    protected $hidden = ['password','remember_token'];

    public function application(){

        return $this->belongsTo(Application::class,'application_id','id');
    }

    public function app(){

        return $this->belongsTo(App::class,'app_id','id');
    }

    public function channel(){

        return $this->belongsTo(Channel::class,'channel_code','channel_code');
    }

    public function product(){

        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function page(){

        return $this->belongsTo(DistributePage::class,'page_id','id');
    }

    public function log(){

        return $this->hasMany(MemberLog::class,'mid','id');
    }

    /**
     * 申请记录
     */
    public function applies()
    {
        return $this->hasMany(Apply::class, 'mid', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * 设备id
     */
    public function device(){
        return $this->hasOne(Device::class,'identifier','identifier_push');
    }


}
