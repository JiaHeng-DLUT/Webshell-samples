<?php

namespace app\common\model;

use think\Model;

class Snsfriend extends Model {

    public $page_info;

    /**
     * 好友添加
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @return type
     */
    public function addSnsfriend($data) {
        $result = db('snsfriend')->insertGetId($data);
        return $result;
    }

    /**
     * 好友列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @param type $page 分页
     * @param type $type 类型
     * @return type
     */
    public function getSnsfriendList($condition, $field = '*', $page = '', $type = 'simple') {
        //得到条件语句
        $order = isset($condition['order']) ? $condition['order'] : 'friend_id desc';
        switch ($type) {
            case 'simple':
                $data = db('snsfriend')->where($condition)->order($order)->field($field)->paginate($page,false,['query' => request()->param()]);
                $this->page_info = $data;
                $friend_list = $data->items();
                break;
            case 'detail':
                $data = db('snsfriend')->alias('snsfriend')->where($condition)->order($order)->field($field)->join('__MEMBER__ member', 'snsfriend.friend_tomid=member.member_id')->paginate($page,false,['query' => request()->param()]);
                $this->page_info = $data;
                $friend_list = $data->items();
                break;
            case 'fromdetail':
                $data = db('snsfriend')->alias('snsfriend')->where($condition)->order($order)->field($field)->join('__MEMBER__ member', 'snsfriend.friend_frommid=member.member_id')->paginate($page,false,['query' => request()->param()]);
                $this->page_info = $data;
                $friend_list = $data->items();
                break;
        }
        return $friend_list;
    }

    /**
     * 获取好友详细
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @return type
     */
    public function getOneSnsfriend($condition, $field = '*') {
        return db('snsfriend')->where($condition)->field($field)->find();
    }

    /**
     * 好友总数
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getSnsfriendCount($condition) {
        //得到条件语句
        $count = db('snsfriend')->where($condition)->count();
        return $count;
    }

    /**
     * 更新好友信息
     * @access public
     * @author csdeshang
     * @param type $data 更新数据
     * @param type $condition 条件
     * @return boolean
     */
    public function editSnsfriend($data, $condition) {
        if (empty($data)) {
            return false;
        }
        //得到条件语句
        $result = db('snsfriend')->where($condition)->update($data);
        return $result;
    }

    /**
     * 删除关注
     * @access public
     * @author csdeshang
     * @param type $condition
     * @return boolean
     */
    public function delSnsfriend($condition) {
        if (empty($condition)) {
            return false;
        }
        $where = '1=1';
        if ($condition['friend_frommid'] != '') {
            $where .= " and friend_frommid='{$condition['friend_frommid']}' ";
        }
        if ($condition['friend_tomid'] != '') {
            $where .= " and friend_tomid='{$condition['friend_tomid']}' ";
        }
        return db('snsfriend')->where($where)->delete();
    }

}