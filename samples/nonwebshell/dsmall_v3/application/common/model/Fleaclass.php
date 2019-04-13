<?php

namespace app\common\model;


use think\Model;

class Fleaclass extends Model
{
    /**
     * 类别列表
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @return array 数组结构的返回结果
     */
    public function getFleaclassList($condition,$field = '*',$order='fleaclass_parent_id asc,fleaclass_sort asc,fleaclass_id asc')
    {
        $result = db('fleaclass')->field($field)->where($condition)->order($order)->select();
        return $result;
    }


    /**
     * 取单个分类的内容
     * @access public
     * @author csdeshang
     * @param int $id 分类ID
     * @return array 数组类型的返回结果
     */
    public function getOneFleaclass($id)
    {
        if (intval($id) > 0) {
            $result = db('fleaclass')->where(array('fleaclass_id'=>$id))->find();
            return $result;
        }
        else {
            return false;
        }
    }

    /**
     * 取指定分类ID的导航链接
     * @access public
     * @author csdeshang
     * @param int $id 父类ID/子类ID
     * @return array $nav_link 返回数组形式类别导航连接
     */
    public function getFleaclassNow($id = 0)
    {
        /**
         * 初始化链接数组
         */
        if (intval($id) > 0) {
            /**
             * 取当前类别信息
             */
            $class = self::getOneFleaclass(intval($id));
            /**
             * 是否是子类
             */
            if ($class['fleaclass_parent_id'] != 0) {
                $parent_1 = self::getOneFleaclass($class['fleaclass_parent_id']);
                if ($parent_1['fleaclass_parent_id'] != 0) {
                    $parent_2 = self::getOneFleaclass($parent_1['fleaclass_parent_id']);
                    if ($parent_2['fleaclass_parent_id'] != 0) {
                        $parent_3 = self::getOneFleaclass($parent_2['fleaclass_parent_id']);
                        $nav_link[] = array('name' => $parent_3['fleaclass_name'], 'fleaclass_id' => $parent_3['fleaclass_id']);
                    }
                    $nav_link[] = array('name' => $parent_2['fleaclass_name'], 'fleaclass_id' => $parent_2['fleaclass_id']);
                }
                $nav_link[] = array('name' => $parent_1['fleaclass_name'], 'fleaclass_id' => $parent_1['fleaclass_id']);
            }
            $nav_link[] = array('name' => $class['fleaclass_name'], 'fleaclass_id' => $id);
        }
        return $nav_link;
    }

    /**
     * 新增
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addFleaclass($data) {
        $result = db('fleaclass')->insertGetId($tmp);
        return $result;
    }

    /**
     * 更新信息
     * @access public
     * @author csdeshang
     * @param array $data 更新数据
     * @return bool 布尔类型的返回结果
     */
    public function editFleaclass($condition, $data) {
        $result = db('fleaclass')->where($condition)->update($data);
        return $result;
    }

    /**
     * 删除分类
     * @access public
     * @author csdeshang
     * @param int $id 记录ID
     * @return bool 布尔类型的返回结果
     */
    public function delFleaclass($id)
    {
        if (intval($id) > 0) {
            $where = " fleaclass_id = '" . intval($id) . "'";
            $result = db('fleaclass')->where($where)->delete();
            return $result;
        }
        else {
            return false;
        }
    }


    /**
     * 取分类列表，按照深度归类
     * @access public
     * @author csdeshang
     * @param int $show_deep 显示深度 为空 则为不限制
     * @param array $condition 条件数组
     * @return array 数组类型的返回结果
     */
    public function getTreeClassList($show_deep = '', $condition = array())
    {
        $class_list = $this->getFleaclassList($condition);

        $result = $this->_getTreeClassList('0', $class_list);
        if (is_array($result)) {
            if (!empty($show_deep)) {
                foreach ($result as $k => $v) {
                    if ($v['deep'] > $show_deep) {
                        unset($result[$k]);
                    }
                }
            }

        }
        return $result;
    }

    /**
     * 递归 整理分类
     * @access public
     * @author csdeshang
     * @param int $parent_id 父ID
     * @param array $class_list 类别内容集合
     * @param int $deep 深度
     * @return array $rs_row 返回数组形式的查询结果
     */
    private function _getTreeClassList($parent_id, $class_list, $deep = 1)
    {
        $result=array();
        if (is_array($class_list)) {
            foreach ($class_list as $k => $v) {
                if ($v['fleaclass_parent_id'] == $parent_id) {
                    $v['deep'] = $deep;
                    $result[] = $v;
                    $tmp = $this->_getTreeClassList($v['fleaclass_id'], $class_list, $deep + 1);
                    if (!empty($tmp)) {
                        $result = @array_merge($result, $tmp);
                    }
                    unset($tmp);
                }
            }
        }
        return $result;
    }

    /**
     * 取指定分类ID下的所有子类
     * @access public
     * @author csdeshang
     * @param int/array $parent_id 父ID 可以单一可以为数组
     * @return array $rs_row 返回数组形式的查询结果
     */
    public function getChildClass($parent_id)
    {
        $all_class = $this->getFleaclassList(array());
        if (is_array($all_class)) {
            if (!is_array($parent_id)) {
                $parent_id = array($parent_id);
            }
            $result = array();
            foreach ($all_class as $k => $v) {
                $fleaclass_id = $v['fleaclass_id'];//返回的结果包括父类
                $fleaclass_parent_id = $v['fleaclass_parent_id'];
                if (in_array($fleaclass_id, $parent_id) || in_array($fleaclass_parent_id, $parent_id)) {
                    $parent_id[] = $v['fleaclass_id'];
                    $result[] = $v;
                }
            }
            return $result;
        }
        else {
            return false;
        }
    }

    /**
     * 获取指定分类的所有下一级别分类
     * @access public
     * @author csdeshang
     * @param int $fleaclass_id 分类ID
     * @return type
     */
    public function getNextLevelGoodsclassById($fleaclass_id)
    {
        return db('fleaclass')->where('fleaclass_parent_id',$fleaclass_id)->select();
    }

    /**
     * 更新闲置主页显示
     * @access public
     * @author csdeshang
     * @param array $data 更新数据
     * @return boolean
     */
    public function setFleaclassindex($data)
    {
        if (empty($data)) {
            return false;
        }
        if (is_array($data)) {
            $tmp = array();
            if (isset($data['fcindex_id1']) && $data['fcindex_id1'] != '') {
                $tmp['fcindex_id1'] = $data['fcindex_id1'];
            }
            if (isset($data['fcindex_id2']) && $data['fcindex_id2'] != '') {
                $tmp['fcindex_id2'] = $data['fcindex_id2'];
            }
            if (isset($data['fcindex_id3']) && $data['fcindex_id3'] != '') {
                $tmp['fcindex_id3'] = $data['fcindex_id3'];
            }
            if (isset($data['fcindex_id4']) && $data['fcindex_id4'] != '') {
                $tmp['fcindex_id4'] = $data['fcindex_id4'];
            }
            if (isset($data['fcindex_name1']) && $data['fcindex_name1'] != '') {
                $tmp['fcindex_name1'] = $data['fcindex_name1'];
            }
            if (isset($data['fcindex_name2']) && $data['fcindex_name2'] != '') {
                $tmp['fcindex_name2'] = $data['fcindex_name2'];
            }
            if (isset($data['fcindex_name3']) && $data['fcindex_name3'] != '') {
                $tmp['fcindex_name3'] = $data['fcindex_name3'];
            }
            if (isset($data['fcindex_name4']) && $data['fcindex_name4'] != '') {
                $tmp['fcindex_name4'] = $data['fcindex_name4'];
            }
            $where = " fcindex_code = '" . $data['fcindex_code'] . "'";
            $result = db('fleaclassindex')->where($where)->update($tmp);
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * 查询闲置主页显示设置
     * @access public
     * @author csdeshang
     * @param array $condition 查询条件
     * @param string $field 查询字段
     * @return type
     */
    public function getFleaclassindex($condition, $field = '*')
    {
        $result = db('fleaclassindex')->field($field)->where($condition)->select();
        return $result;
    }
}