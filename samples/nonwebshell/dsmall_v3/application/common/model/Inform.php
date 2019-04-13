<?php

namespace app\common\model;

use think\Model;

class Inform extends Model {

    public $page_info;

    /**
     * 查询举报数量
     * @access public
     * @author csdeshang
     * @param array $condition 查询条件
     * @return int
     */
    public function getInformCount($condition) {
        return db('inform')->where($condition)->count();
    }

    /**
     * 增加
     * @access public
     * @author csdeshang
     * @param array $data  参数内容
     * @return bool
     */
    public function addInform($data) {
        return db('inform')->insertGetId($data);
    }

    /**
     * 更新
     * @access public
     * @author csdeshang
     * @param array $update_array 更新数据
     * @param array $where_array 更新条件
     * @return bool
     */
    public function editInform($update_array, $where_array) {
        return db('inform')->where($where_array)->update($update_array);
    }

    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return bool
     */
    public function delInform($condition) {
        return db('inform')->where($condition)->delete();
    }

    /**
     * 获得列表
     * @access public
     * @author csdeshang
     * @param array $condition 查询条件
     * @param int $page 分页
     * @param string $order 排序
     * @return array
     */
    public function getInformList($condition = '', $page = '',$order = 'inform_id desc') {
        $res = db('inform')->alias('inform')->join('__INFORMSUBJECT__ inform_subject', 'inform.informsubject_id = inform_subject.informsubject_id', 'LEFT')->where($condition)->order($order)->paginate($page, false, ['query' => request()->param()]);
        $this->page_info = $res;
        return $res->items();
    }

    /**
     * 根据id获取举报详细信息
     * @access public
     * @author csdeshang
     * @param array $condition 查询条件
     * @return array
     */
    public function getOneInform($condition) {
        return db('inform')->where($condition)->find();
    }

    /**
     *  判断该商品是否正在被举报
     * @access public
     * @author csdeshang
     *  @param int $goods_id 商品id
     *  @return bool
     */
    public function isProcessOfInform($goods_id) {

        $condition = array();
        $condition['inform_goods_id'] = $goods_id;
        $condition['inform_state'] = 1;
        $inform = $this->getOneInform($condition);
        if (!empty($inform)) {
            return true;
        } else {
            return false;
        }
    }


}
