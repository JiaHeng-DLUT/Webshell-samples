<?php
namespace app\common\model;
use think\Model;

class Storesnscomment extends Model
{
    public $page_info;
    /**
     * 店铺动态评论列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段 
     * @param string $order 排序
     * @param int $limit 限制
     * @param int $page 分页
     * @return array
     */
    public function getStoresnscommentList($condition, $field = '*', $order = 'storesnscomm_id desc', $limit = 0, $page = 0) {
        $res= db('storesnscomment')->where($condition)->field($field)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info=$res;
        return $res->items();
    }

    /**
     * 店铺评论数量
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getStoresnscommentCount($condition) {
        return db('storesnscomment')->where($condition)->count();
    }

    /**
     * 获取单条评论
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return array
     */
    public function getStoresnscommentInfo($condition, $field = '*') {
        return db('storesnscomment')->where($condition)->field($field)->find();
    }

    /**
     * 保存店铺评论
     * @access public
     * @author csdeshang
     * @param array $data 数据
     * @return boolean
     */
    public function addStoresnscomment($data) {
        return db('storesnscomment')->insertGetId($data);
    }
    
    /**
     * 更新店铺评论
     * @access public
     * @author csdeshang
     * @param type $update 更新数据
     * @param type $condition 条件
     * @return type
     */
    public function editStoresnscomment($update, $condition) {
        return db('storesnscomment')->where($condition)->update($update);
    }

    /**
     * 删除店铺动态评论
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function delStoresnscomment($condition) {
        return db('storesnscomment')->where($condition)->delete();
    }
}