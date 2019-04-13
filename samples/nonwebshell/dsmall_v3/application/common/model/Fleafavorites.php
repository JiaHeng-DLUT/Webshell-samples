<?php

namespace app\common\model;

use think\Model;
use think\Db;

class Fleafavorites extends Model {

    public $page_info;

    /**
     * 收藏列表
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @param int $page 分页页数
     * @return array 数组类型的返回结果
     */
    public function getFleafavoritesList($condition, $page = '') {
        if ($page) {
            $order = isset($condition['order']) ? $condition['order'] : 'fleafav_time desc';
            $res = db('fleafavorites')->where($condition)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            $list_favorites = $res->items();
            return $list_favorites;
        } else {
            $order = $condition['order'] ? $condition['order'] : 'fleafav_time desc';
            return db('fleafavorites')->where($condition)->order($order)->select();
        }
    }


    /**
     * 取单个收藏的内容
     * @access public
     * @author csdeshang
     * @param type $fav_id 收藏ID
     * @param type $type   收藏类型
     * @param type $member_id 会员ID
     * @return boolean
     */
    public function getOneFleafavorites($fav_id, $type, $member_id) {
        if (intval($fav_id) > 0) {
            $result = db('fleafavorites')->where('fleafav_id', intval($fav_id))->where('fleafav_type', $type)->where('member_id', $member_id)->field('fleafav_id,member_id,fleafav_type')->find();
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 新增收藏
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addFleafavorites($data) {
        $result = db('fleafavorites')->insert($data);
        return $result;
    }

    /**
     * 验证是否为当前用户收藏
     * @access public
     * @author csdeshang
     * @param type $fav_id 收藏ID
     * @param type $fav_type 收藏类型
     * @param type $member_id 会员ID
     * @return boolean
     */
    public function checkFleafavorites($fav_id, $fav_type, $member_id) {
        if (intval($fav_id) == 0 || empty($fav_type) || intval($member_id) == 0) {
            return true;
        }
        $result = self::getOneFleafavorites($fav_id, $fav_type, $member_id);
        if ($result['member_id'] == $member_id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param type $condition 
     * @return boolean
     */
    public function delFleafavorites($condition) {
        $result = db('fleafavorites')->where($condition)->delete();
        return $result;
    }

}
