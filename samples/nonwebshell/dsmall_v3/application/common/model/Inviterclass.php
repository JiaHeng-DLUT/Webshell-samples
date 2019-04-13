<?php

namespace app\common\model;

use think\Model;

class Inviterclass extends Model {

    //获取分销员所对应的等级
    public function getInviterclass($inviterclass_amount){
        $inviterclass_name='';
        $inviterclass_list=db('inviterclass')->order('inviterclass_amount asc')->select();
        foreach($inviterclass_list as $inviterclass){
            if($inviterclass_amount>=$inviterclass['inviterclass_amount']){
                $inviterclass_name=$inviterclass['inviterclass_name'];
            }
        }
        return $inviterclass_name;
    }

}
