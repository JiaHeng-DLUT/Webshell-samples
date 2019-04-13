<?php

namespace app\common\model;


use think\Model;

class Rcblog extends Model
{
    public $page_info;
    
    /**
     * 获取列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $page 分页
     * @param string $order 排序
     * @return array
     */
    public function getRechargecardBalanceLogList($condition, $page, $order)
    {
        $res =db('rcblog')->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info=$res;
        return $res->items();
    }
}