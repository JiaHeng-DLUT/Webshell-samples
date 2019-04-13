<?php

namespace app\common\model;

use think\Model;

class Navigation extends Model {

    public $page_info;

    /**
     * 获取导航列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param int $page 分页
     * @param string $order 排序
     * @return array
     */
    public function getNavigationList($condition, $page = '', $order = 'nav_sort desc') {
        if ($page) {
            $nav_list = db('navigation')->where($condition)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $nav_list;
            return $nav_list->items();
        } else {
            return db('navigation')->where($condition)->order('nav_sort')->select();
        }
    }

    /**
     * 新增导航
     * @access public
     * @author csdeshang
     * @param type $data 参数内容
     * @return bool
     */
    public function addNavigation($data) {
        $add_navigation = db('navigation')->insert($data);
        return $add_navigation;
    }
    /**
     * 编辑导航
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @param type $condition 条件
     * @return bool
     */
    public function eidtNavigation($data, $condition) {
        return db('navigation')->where($condition)->update($data);
    }
    
    /**
     * 获取单个导航
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return array
     */
    public function getOneNavigation($condition) {
        return db('navigation')->where($condition)->find();
    }
    /**
     * 删除导航
     * @access public
     * @author csdeshang
     * @param type $conditions 条件
     * @return bool
     */
    public function delNavigation($conditions) {
        return db('navigation')->where($conditions)->delete();
    }

}
