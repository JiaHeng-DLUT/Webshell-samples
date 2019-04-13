<?php
namespace app\common\model;


use think\Model;

class Storemsg extends Model
{
    public $page_info;

    /**
     * 新增店铺消息
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return type
     */
    public function addStoremsg($data) {
        $data['storemsg_addtime'] = TIMESTAMP;
        $storemsg_id = db('storemsg')->insertGetId($data);
        if (config('node_chat')) {
            @file_get_contents(config('node_site_url').'/store_msg/?id='.$storemsg_id.'&time='.TIMESTAMP);
        }
        return $storemsg_id;
    }

    /**
     * 更新店铺消息表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $update 更新数据
     * @return bool
     */
    public function editStoremsg($condition, $update) {
        return db('storemsg')->where($condition)->update($update);
    }

    /**
     * 查看店铺消息详细
     * @access public
     * @author csdeshang
     * @param unknown $condition 条件
     * @param string $field 字段
     * @return bool
     */
    public function getStoremsgInfo($condition, $field = '*') {
        return db('storemsg')->field($field)->where($condition)->find();

    }

    /**
     * 店铺消息列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @param type $page 分页
     * @param type $order 排序
     * @return type
     */
    public function getStoremsgList($condition, $field = '*', $page = '0', $order = 'storemsg_id desc') {
        $return =db('storemsg')->field($field)->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info=$return;
        return $return->items();
    }

    /**
     * 计算消息数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getStoremsgCount($condition) {
        return db('storemsg')->where($condition)->count();
    }

    /**
     * 删除店铺消息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return bool
     */
    public function delStoremsg($condition) {
        db('storemsg')->where($condition)->delete();
    }
}