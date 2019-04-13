<?php
namespace app\common\model;
use think\Model;

class Complain extends Model {

    public $page_info;

    /**
     * 投诉数量
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @return int
     */
    public function getComplainCount($condition) {
        return db('complain')->where($condition)->count();
    }

    /**
     * 增加
     * @access public
     * @author csdeshang 
     * @param array $data 参数内容
     * @return bool
     */
    public function addComplain($data) {
        return db('complain')->insertGetId($data);
    }

    /**
     * 更新
     * @access public
     * @author csdeshang 
     * @param array $update_array 更新数据
     * @param array $where_array 更新条件
     * @return boll
     */
    public function editComplain($update_array, $where_array) {
        return db('complain')->where($where_array)->update($update_array);
    }

    /**
     * 删除
     * @access public
     * @author csdeshang 
     * @param array $condition 条件
     * @return bool
     */
    public function delComplain($condition) {
        return db('complain')->where($condition)->delete();
    }

    /**
     * 获得投诉列表
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @param int $page 分页信息
     * @param str $order 排序
     * @return array
     */
    public function getComplainList($condition = '', $page = '',$order='complain_id asc') {
        if ($page) {
            $res = db('complain')->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('complain')->where($condition)->order($order)->select();
        }
    }

    /**
     * 获得投诉商品列表
     * @access public
     * @author csdeshang 
     * @param array $complain_list 投诉列表
     * @return array
     */
    public function getComplainGoodsList($complain_list) {
        $goods_ids = array();
        if (!empty($complain_list) && is_array($complain_list)) {
            foreach ($complain_list as $key => $value) {
                $goods_ids[] = $value['order_goods_id']; //订单商品表编号
            }
        }
        $condition = array();
        $condition['rec_id'] = array('in', $goods_ids);
        $res = db('ordergoods')->where($condition)->select();
        return ds_change_arraykey($res, 'rec_id');
    }

    /**
     * 检查投诉是否存在
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @return boolean
     */
    public function isComplainExist($condition = '') {
        $list = db('complain')->where($condition)->select();
        if (empty($list)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 根据id获取投诉详细信息
     * @access public
     * @author csdeshang 
     * @param int $complain_id 投诉ID
     * @return type
     */
    public function getOneComplain($complain_id) {
        $where = array();
        $where['complain_id'] = intval($complain_id);
        return db('complain')->where($where)->find();
    }


}