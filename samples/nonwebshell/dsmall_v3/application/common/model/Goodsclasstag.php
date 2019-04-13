<?php

namespace app\common\model;

use think\Db;
use think\Model;

class Goodsclasstag extends Model {
    public $page_info;
    /**
     * 删除TAG分类
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function delGoodsclasstag($condition) {
        return db('goodsclasstag')->where($condition)->delete();
    }

    /**
     * TAG列表
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @param int $page 分页信息
     * @param str $field 字段
     * @return array 数组结构的返回结果
     */
    public function getGoodsclasstagList($condition = array(), $page = '', $field = '*') {
        if ($page) {
            $result = db('goodsclasstag')->field($field)->where($condition)->paginate($page,false,['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        } else {
            $result = db('goodsclasstag')->field($field)->where($condition)->select();
            return $result;
        }
    }

    /**
     * TAG添加
     * @access public
     * @author csdeshang
     * @param array $param 参数数据
     * @return bool
     */
    public function addGoodsclasstag($param) {
        $class_id_1 = '';
        $class_id_2 = '';
        $class_id_3 = '';
        $class_name_1 = '';
        $class_name_2 = '';
        $class_name_3 = '';
        $class_id = '';
        $type_id = '';
        $condition_str = '';

        if (is_array($param) && !empty($param)) { //一级
            foreach ($param as $value) {
                $class_id_1 = $value['gc_id'];
                $class_name_1 = trim($value['gc_name']);
                $class_id = $value['gc_id'];
                $type_id = $value['type_id'];
                $class_id_2 = '';
                $class_id_3 = '';
                $class_name_2 = '';
                $class_name_3 = '';

                if (is_array($value['sub_class']) && !empty($value['sub_class'])) { //二级
                    foreach ($value['sub_class'] as $val) {
                        $class_id_2 = $val['gc_id'];
                        $class_name_2 = trim($val['gc_name']);
                        $class_id = $val['gc_id'];
                        $type_id = $val['type_id'];

                        if (is_array($val['sub_class']) && !empty($val['sub_class'])) { //三级
                            foreach ($val['sub_class'] as $v) {
                                $class_id_3 = $v['gc_id'];
                                $class_name_3 = trim($v['gc_name']);
                                $class_id = $v['gc_id'];
                                $type_id = $v['type_id'];

                                //合并成sql语句
                                $condition_str .= '("' . $class_id_1 . '", "' . $class_id_2 . '", "' . $class_id_3 . '", "' . $class_name_1 . '&nbsp;&gt;&nbsp;' . $class_name_2 . '&nbsp;&gt;&nbsp;' . $class_name_3 . '", "' . $class_name_1 . ',' . $class_name_2 . ',' . $class_name_3 . '", "' . $class_id . '", "' . $type_id . '"),';
                            }
                        } else {
                            //合并成sql语句
                            $condition_str .= '("' . $class_id_1 . '", "' . $class_id_2 . '", "", "' . $class_name_1 . '&nbsp;&gt;&nbsp;' . $class_name_2 . '", "' . $class_name_1 . ',' . $class_name_2 . '", "' . $class_id . '", "' . $type_id . '"),';
                        }
                    }
                } else {
                    //合并成sql语句
                    $condition_str .= '("' . $class_id_1 . '", "", "", "' . $class_name_1 . '", "' . $class_name_1 . '", "' . $class_id . '", "' . $type_id . '"),';
                }
            }
        } else {
            return false;
        }

        $condition_str = trim($condition_str, ',');
        return Db::query("insert into `" . config('database.prefix')."goodsclasstag` (`gc_id_1`,`gc_id_2`,`gc_id_3`,`gctag_name`,`gctag_value`,`gc_id`,`type_id`) values " . $condition_str);
    }

    /**
     * TAG清空
     * @access public
     * @author csdeshang
     * @return type
     */
    public function clearGoodsclasstag() {
        return Db::query("TRUNCATE TABLE `" . config('database.prefix') . "goodsclasstag`");
    }

    /**
     * TAG更新
     * @access public
     * @author csdeshang
     * @param type $param 参数内容
     * @param type $gctag_id tagID 
     * @return bool
     */
    public function editGoodsclasstag($param,$gctag_id) {
        return db('goodsclasstag')->where("gctag_id = '" . $gctag_id . "'")->update($param);
    }

    /**
     * TAG删除
     * @access public
     * @author csdeshang
     * @param int $id
     * @return bool
     */
    public function delGoodsclasstagByIds($id) {
        return db('goodsclasstag')->where('gctag_id in (' . $id . ')')->delete();
    }


}

?>
