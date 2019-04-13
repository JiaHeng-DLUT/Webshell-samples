<?php

namespace app\common\model;

use think\Model;

class Storegoodsclass extends Model {

 
    /**
     * 单个类别内容提取
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return array|bool
     */
    public function getStoregoodsclassInfo($condition, $field = '*') {
        if (empty($condition)) {
            return false;
        }
        return db('storegoodsclass')->where($condition)->field($field)->find();
    }

    /**
     * 类别添加
     * @access public
     * @author csdeshang
     * @param array $data 分类数据
     * @return bool 
     */
    public function addStoregoodsclass($data) {
        if (empty($data)) {
            return false;
        }
        $result = db('storegoodsclass')->insertGetId($data);
        if ($result) {
            $this->_dStoregoodsclassCache($data['store_id']);
        }
        return $result;
    }


    /**
     * 类别修改
     * @access public
     * @author csdeshang
     * @param type $data
     * @param type $where
     * @return boolean
     */
    public function editStoregoodsclass($data, $where) {
        if (empty($data)) {
            return false;
        }
        $result = db('storegoodsclass')->where($where)->update($data);
        if ($result) {
            $this->_dStoregoodsclassCache($where['store_id']);
        }
        return $result;
    }

    /**
     * 店铺商品分类删除
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @return boolean
     */
    public function delStoregoodsclass($where) {
        if (empty($where)) {
            return false;
        }
        $result = db('storegoodsclass')->where($where)->delete();
        if ($result) {
            $this->_dStoregoodsclassCache($where['store_id']);
        }
        return $result;
    }

    /**
     * 类别列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $order 排序
     * @return array
     */
    public function getStoregoodsclassList($condition, $order = 'storegc_parent_id asc,storegc_sort asc,storegc_id asc') {
        $result = db('storegoodsclass')->where($condition)->order($order)->select();
        return $result;
    }

    /**
     * 取分类列表(前台店铺页左侧用到)
     * @access public
     * @author csdeshang
     * @param type $store_id 店铺id
     * @return type
     */
    public function getShowTreeList($store_id) {
        $info = $this->_rStoregoodsclassCache($store_id);
        if (empty($info)) {
            $show_class = array();
            $class_list = $this->getStoregoodsclassList(array('store_id' => $store_id, 'storegc_state' => '1'));
            if (is_array($class_list) && !empty($class_list)) {
                foreach ($class_list as $val) {
                    if ($val['storegc_parent_id'] == 0) {
                        $show_class[$val['storegc_id']] = $val;
                    } else {
                        if (isset($show_class[$val['storegc_parent_id']])) {
                            $show_class[$val['storegc_parent_id']]['children'][] = $val;
                        }
                    }
                }
            }
            $info['info'] = serialize($show_class);
            $this->_wStoregoodsclassCache($store_id, $info);
        }
        $show_class = unserialize($info['info']);
        return $show_class;
    }

    /**
     * 取分类列表，按照深度归类
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @param int $show_deep 显示深度
     * @return array 数组类型的返回结果
     */
    public function getTreeClassList($condition, $show_deep = '2') {
        $class_list = $this->getStoregoodsclassList($condition);
        $show_deep = intval($show_deep);
        $result = array();
        if (is_array($class_list) && !empty($class_list)) {
            $result = $this->_getTreeClassList($show_deep, $class_list);
        }
        return $result;
    }

    /**
     * 递归 整理分类
     * @access public
     * @author csdeshang
     * @param int $show_deep 显示深度
     * @param array $class_list 类别内容集合
     * @param int $deep 深度
     * @param int $parent_id 父类编号
     * @param int $i 上次循环编号
     * @return array 返回数组形式的查询结果
     */
    private function _getTreeClassList($show_deep, $class_list, $deep = 1, $parent_id = 0, $i = 0) {
        static $show_class = array(); //树状的平行数组
        if (is_array($class_list) && !empty($class_list)) {
            $size = count($class_list);
            if ($i == 0)
                $show_class = array(); //从0开始时清空数组，防止多次调用后出现重复
            for ($i; $i < $size; $i++) {//$i为上次循环到的分类编号，避免重新从第一条开始
                $val = $class_list[$i];
                $storegc_id = $val['storegc_id'];
                $storegc_parent_id = $val['storegc_parent_id'];
                if ($storegc_parent_id == $parent_id) {
                    $val['deep'] = $deep;
                    $show_class[] = $val;
                    if ($deep < $show_deep && $deep < 2) {//本次深度小于显示深度时执行，避免取出的数据无用
                        $this->_getTreeClassList($show_deep, $class_list, $deep + 1, $storegc_id, $i + 1);
                    }
                }
                if ($storegc_parent_id > $parent_id)
                    break; //当前分类的父编号大于本次递归的时退出循环
            }
        }
        return $show_class;
    }

    /**
     * 取分类列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return array
     */
    public function getClassTree($condition) {
        $class_list = $this->getStoregoodsclassList($condition);
        $d = array();
        if (is_array($class_list)) {
            foreach ($class_list as $v) {
                if ($v['storegc_parent_id'] == 0) {
                    $d[$v['storegc_id']] = $v;
                } else {
                    if (isset($d[$v['storegc_parent_id']]))
                        $d[$v['storegc_parent_id']]['child'][] = $v; //防止出现父类不显示时子类被调出
                }
            }
        }
        return $d;
    }

    /**
     * 读取店铺商品分类缓存
     * @access public
     * @author csdeshang
     * @param INT $store_id 店铺ID
     * @return type
     */
    private function _rStoregoodsclassCache($store_id) {
        return rcache($store_id, 'store_goods_class');
    }

    /**
     * 写入店铺商品分类缓存
     * @access public
     * @author csdeshang
     * @param int $store_id 店铺ID
     * @param array $info 信息
     * @return boolean
     */
    private function _wStoregoodsclassCache($store_id, $info) {
        return wcache($store_id, $info, 'store_goods_class');
    }

    /**
     * 删除店铺商品分类缓存
     * @access public
     * @author csdeshang
     * @param int $store_id 店铺ID
     * @return boolean
     */
    private function _dStoregoodsclassCache($store_id) {
        return dcache($store_id, 'store_goods_class');
    }

}

?>
