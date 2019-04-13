<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-11-9
 * Time: 11:40
 */

namespace App\Traits;


use App\Models\Apply;
use App\Models\ChannelCeiling;
use App\Models\ChannelReduce;
use App\Models\DeductionApply;
use App\Models\DeductionRegister;

use App\Models\ReduceRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait Deduction
{
    private $ignore_member = 5;

}