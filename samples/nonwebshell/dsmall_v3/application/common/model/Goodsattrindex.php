<?php

namespace app\common\model;

use think\Model;

class Goodsattrindex extends Model {
    /**
     * 对应列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return array
     */
    public function getGoodsAttrIndexList($condition, $field = '*') {
        return db('goodsattrindex')->where($condition)->field($field)->select();
    }
    
}

