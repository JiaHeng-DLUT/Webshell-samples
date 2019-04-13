<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemMessageClick extends Model
{

    use SoftDeletes;
    protected $guarded = [];
}
