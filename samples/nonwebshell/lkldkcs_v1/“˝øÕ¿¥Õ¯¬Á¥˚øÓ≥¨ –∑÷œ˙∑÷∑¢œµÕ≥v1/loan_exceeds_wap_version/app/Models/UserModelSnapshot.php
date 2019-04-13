<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModelSnapshot extends Model
{
    protected $casts=[
        'client_user_ids'=>'json',
        'config'=>'json'
    ];

    protected $fillable=['id','user_model_id','refresh_type','client_user_ids','client_user_num','config','created_at','updated_at'];


    protected function userModel(){

        return $this->belongsTo(UserModel::class,'user_model_id','id');
    }

}
