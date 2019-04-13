<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleShare extends Model
{
    protected $guarded = [];

    protected $casts = [
        'operate_params'=>'json'
    ];
}
