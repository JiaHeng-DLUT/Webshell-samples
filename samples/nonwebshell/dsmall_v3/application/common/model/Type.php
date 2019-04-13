<?php

/**
 * 类型管理
 *
 */

namespace app\common\model;

use think\Db;
use think\Model;

class Type extends Model {
    
    public $page_info;
    public function getTypebrandList($condition, $field = '*') {
        return db('typebrand')->field($field)->where($condition)->select();
    }

    /**
     * 根据类型查找规格
     * @access public
     * @author csdeshang
     * @param  array   $where  条件
     * @param  string  $field  字段
     * @param  string  $order  排序
     * @return array   返回数组
     */
    public function getSpecByType($where, $field, $order = 's.sp_sort asc, s.sp_id asc') {

        $result = db('typespec')->alias('t')->field($field)->where($where)->join('__SPEC__ s', 't.sp_id = s.sp_id')->order($order)->select();
        return $result;
    }

    /**
     * 根据类型获得规格、类型、属性信息
     * @access public
     * @author csdeshang
     * @param int $type_id 类型ID
     * @param int $store_id 店铺ID
     * @param int $gc_id 商品分类ID
     * @return array
     */
    public function getAttribute($type_id, $store_id, $gc_id) {
        $spec_list = $attr_list = $brand_list = array();
        if ($type_id > 0) {
            $spec_list = $this->typeRelatedJoinList(array('type_id' => $type_id), 'spec', 'spec.sp_id as sp_id, spec.sp_name as sp_name');
            $attr_list = $this->typeRelatedJoinList(array('attribute.type_id' => $type_id), 'attr', 'attribute.attr_id as attr_id, attribute.attr_name as attr_name, attribute_value.attrvalue_id as attrvalue_id, attribute_value.attrvalue_name as attrvalue_name');
            $brand_list = $this->typeRelatedJoinList(array('type_id' => $type_id), 'brand', 'brand.brand_id as brand_id,brand.brand_name as brand_name,brand.brand_initial as brand_initial');

            // 整理数组
            $spec_json = array();
            if (is_array($spec_list) && !empty($spec_list)) {
                $array = array();
                foreach ($spec_list as $val) {
                    $spec_value_list = model('spec')->getSpecvalueList(array('sp_id' => $val['sp_id'], 'gc_id' => $gc_id, 'store_id' => $store_id));
                    $a = array();
                    foreach ($spec_value_list as $v) {
                        $b = array();
                        $b['spvalue_id'] = $v['spvalue_id'];
                        $b['spvalue_name'] = $v['spvalue_name'];
                        $b['spvalue_color'] = $v['spvalue_color'];
                        $a[] = $b;
                        $spec_json[$val['sp_id']][$v['spvalue_id']]['spvalue_name'] = $v['spvalue_name'];
                        $spec_json[$val['sp_id']][$v['spvalue_id']]['spvalue_color'] = $v['spvalue_color'];
                    }
                    $array[$val['sp_id']]['sp_name'] = $val['sp_name'];
                    $array[$val['sp_id']]['value'] = $a;
                }
                $spec_list = $array;
            }
            if (is_array($attr_list) && !empty($attr_list)) {
                $array = array();
                foreach ($attr_list as $val) {
                    $a = array();
                    $a['attrvalue_id'] = $val['attrvalue_id'];
                    $a['attrvalue_name'] = $val['attrvalue_name'];

                    $array[$val['attr_id']]['attr_name'] = $val ['attr_name'];
                    $array[$val['attr_id']]['value'][] = $a;
                }
                $attr_list = $array;
            }
        } else {
            $spec_json = array();
        }
        if (empty($brand_list)) {
            $brand_list = model('brand')->getBrandPassedList(array(), '*', 0, 'brand_initial asc, brand_sort asc');
        }
        return array($spec_json, $spec_list, $attr_list, $brand_list);
    }

    /**
     * 新增商品商品与属性对应
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品ID
     * @param int $commonid 商品公共表ID
     * @param array $data 数据
     * @return boolean
     */
    public function addGoodsType($goods_id, $commonid, $data) {
        // 商品与属性对应
        $sa_array = array();
        $sa_array['goods_id'] = $goods_id;
        $sa_array['goods_commonid'] = $commonid;
        $sa_array['gc_id'] = $data['cate_id'];
        $sa_array['type_id'] = $data['type_id'];
        if (is_array($data['attr'])) {
            $sa_array['value'] = $data['attr'];
            $this->typeGoodsRelatedAdd($sa_array, 'goodsattrindex');
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param array $conditoin 条件
     * @return bool
     */
    public function delGoodsAttr($conditoin) {
        return db('goodsattrindex')->where($conditoin)->delete();
    }

    /**
     * 类型列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param int $page 分页
     * @param string $field 字段
     * @param string $order 排序
     * @return array
     */
    public function getTypeList($condition, $page = '', $field = '*',$order='type_sort asc') {
        if ($page) {
            $result = db('type')->where($condition)->field($field)->order($order)->paginate($page,false,['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        } else {
            $list_type = db('type')->field($field)->where($condition)->order($order)->select();
            return $list_type;
        }
    }

    /**
     * 添加类型信息
     * @access public
     * @author csdeshang
     * @param string $table 表名
     * @param array $data 数据
     * @return bool
     */
    public function typeAdd($table, $data) {
        return db($table)->insertGetId($data);
    }

    /**
     * 添加对应关系信息
     * @access public
     * @author csdeshang
     * @param string $table 表名
     * @param array $data 一维数组
     * @param string $id ID编号
     * @param string $row 列名
     * @return bool
     */
    public function typeRelatedAdd($table, $data, $id, $row = '') {
        $insert_str = '';
        if (is_array($data)) {
            foreach ($data as $v) {
                $insert_str .= "('" . $id . "', '" . $v . "'),";
            }
        } else {
            $insert_str .= "('" . $id . "', '" . $data . "'),";
        }
        $insert_str = rtrim($insert_str, ',');
        return Db::query("insert into `" . DBPRE . $table . "` " . $row . " values " . $insert_str);
    }

   
    /**
     * 添加商品与规格、属性对应关系信息
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @param type $table 表名
     * @param type $type 类型
     * @return type 
     */
    public function typeGoodsRelatedAdd($data, $table, $type = "") {
        if (is_array($data ['value']) && !empty($data ['value'])) {
            $insert_array = array();
            foreach ($data ['value'] as $key => $val) {
                if (is_array($val) && !empty($val)) {
                    foreach ($val as $k => $v) {
                        if (intval($k) > 0 && $k != 'name') {
                            $insert = array();
                            $insert['goods_id'] = $data ['goods_id'];
                            $insert['goods_commonid'] = $data ['goods_commonid'];
                            $insert['gc_id'] = $data ['gc_id'];
                            $insert['type_id'] = $data ['type_id'];
                            $insert['attr_id'] = $key;
                            $insert['attrvalue_id'] = $k;
                            $insert_array[] = $insert;
                        }
                    }
                }
            }
            db($table)->insertAll($insert_array);
        }
    }

  
    /**
     * 对应关系信息列表
     * @access public
     * @author csdeshang
     * @param type $table 表名
     * @param type $condition 条件
     * @param type $field 字段
     * @return type
     */
    public function typeRelatedList($table, $condition, $field = '*') {
        $list_type = db($table)->field($field)->where($condition)->select();
        return $list_type;
    }

    /**
     * 计算商品类型与品牌对应表数量
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return int
     */
    public function getTypebrandCount($condition) {
        return db('typebrand')->where($condition)->count();
    }

    /**
     * 类型与属性关联信息,多表查询
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $type 类型参数
     * @param string $field 字段
     * @param string $order 排序
     * @return array
     */
    public function typeRelatedJoinList($condition, $type = '', $field = '*', $order = '') {
        $array = array();
        switch ($type) {
            case 'spec':
                $order = !empty($order) ? $order : 'spec.sp_id asc, spec.sp_sort asc';
                $result = db('typespec')->alias('type_spec')->field($field)->join('__SPEC__ spec', 'type_spec.sp_id = spec.sp_id')->where($condition)->order($order)->select();
                break;
            case 'attr':
                $order = !empty($order) ? $order : 'attribute.attr_sort asc, attribute_value.attrvalue_sort asc, attribute_value.attrvalue_id asc';
                $result = db('attributevalue')->alias('attribute_value')->join('__ATTRIBUTE__ attribute', 'attribute.attr_id=attribute_value.attr_id')->where($condition)->order($order)->select();
                break;
            case 'brand':
                $condition['brand_apply'] = 1;  //只查询通过的品牌
                $order = !empty($order) ? $order : 'brand.brand_initial asc, brand.brand_sort asc';
                $result = db('typebrand')->alias('type_brand')->join('__BRAND__ brand', 'type_brand.brand_id=brand.brand_id')->where($condition)->order($order)->select();
                break;
        }
        return $result;
    }

    /**
     * 删除类型
     * @param type $condition
     * @return type
     */
    public function delType($condition) {
        return db('type')->where($condition)->delete();
    }
    
    /**
     * 增加类型品牌
     * @param type $data
     * @return type
     */
    public function addTypebrand($data){
        return db('typebrand')->insertAll($data);
    }
    
    /**
     * 增加类型规格
     * @param type $data
     * @return type
     */
    public function addTypespec($data){
        return db('typespec')->insertAll($data);
    }
    
    /**
     * 获取单个类型
     * @param type $condition
     * @return type
     */
    public function getOneType($condition){
        return db('type')->where($condition)->find();
    }
    
    /**
     * 编辑类型
     * @param type $condition
     * @param type $data
     * @return type
     */
    public function editType($condition,$data){
        return db('type')->where($condition)->update($data);
    }
    
    /**
     * 获取单个属性
     * @param type $condition
     * @return type
     */
    public function getOneAttribute($condition){
        return db('attribute')->where($condition)->find();
    }
    
    /**
     * 获取属性值列表
     * @param type $condition
     * @return type
     */
    public function getAttributevalueList($condition){
        return db('attributevalue')->where($condition)->select();
    }
    
    /**
     * 编辑属性值
     * @param type $condition
     * @param type $data
     * @return type
     */
    public function editAttributevalue($condition,$data){
        return db('attributevalue')->where($condition)->update($data);
    }
    
    /**
     * 增加属性值
     * @param type $data
     * @return type
     */
    public function addAttributevalue($data){
        return db('attributevalue')->insert($data);
    }
    
    /**
     * 编辑属性
     * @param type $condition
     * @param type $data
     * @return type
     */
    public function editAttribute($condition,$data){
        return db('attribute')->where($condition)->update($data);
    }
    
        
    /**
     * 删除属性值
     * @param type $condition
     * @return type
     */
    public function delAttributevalue($condition){
        return db('attributevalue')->delete($condition);
    }
    
    /**
     * 删除类型品牌
     * @param type $condition
     * @return type
     */
    public function delTypebrand($condition){
        return db('typebrand')->where($condition)->delete();
    }
    
    /**
     * 删除类型规格
     * @param type $condition
     * @return type
     */
    public function delTypespec($condition){
        return db('typespec')->where($condition)->delete();
    }
    
    /**
     * 删除类型属性
     * @param type $condition
     * @return type
     */
    public function delAttribute($condition){
        return db('attribute')->where($condition)->delete();
    }


}