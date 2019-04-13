<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Circle extends Model
{
    protected $guarded = [];
    protected  $fillable=['url','title','copy_content','intro','slug','sort'];
}
