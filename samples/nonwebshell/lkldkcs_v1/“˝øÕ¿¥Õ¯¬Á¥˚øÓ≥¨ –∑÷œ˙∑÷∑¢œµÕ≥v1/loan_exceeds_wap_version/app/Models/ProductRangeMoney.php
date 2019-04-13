<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRangeMoney extends Model
{

    protected $fillable=['type','min','max','per_value','unit','sort'];
}
