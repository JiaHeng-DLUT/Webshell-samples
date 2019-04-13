<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    protected $fillable=['function_name','field_name','slug','content','model_ids'];
}
