<?php

namespace app\common\model;

use think\Model;

class Evaluatestore extends Model {
public $page_info;
    /**
     * 查询店铺评分列表
     * @access public
     * @author csdeshang
     * @param array $condition 查询条件
     * @param int $page 分页数
     * @param string $order 排序
     * @param string $field 字段
     * @return array
     */
    public function getEvaluatestoreList($condition, $page = null, $order = 'seval_id desc', $field = '*') {
        $list = db('evaluatestore')->field($field)->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info=$list;
        return $list->items();
    }

    /**
     * 获取店铺评分信息
     * @access public
     * @author csdeshang
     * @param type $condition 查询条件
     * @param type $field 字段
     * @return type
     */
    public function getEvaluatestoreInfo($condition, $field = '*') {
        $list = db('evaluatestore')->field($field)->where($condition)->find();
        return $list;
    }

    /**
     * 根据店铺编号获取店铺评分数据
     * @access public
     * @author csdeshang
     * @param int $store_id 店铺编号
     * @param int $storeclass_id 分类编号，如果传入分类编号同时返回行业对比数据
     * @return array
     */
    public function getEvaluatestoreInfoByStoreID($store_id, $storeclass_id = 0) {
        $prefix = 'evaluate_store_info';
        $info = rcache($store_id, $prefix);
        if (empty($info)) {
            $info = array();
            $info['store_credit'] = $this->_getEvaluatestore(array('seval_storeid' => $store_id));
            $info['store_credit_average'] = round((($info['store_credit']['store_desccredit']['credit'] + $info['store_credit']['store_servicecredit']['credit'] + $info['store_credit']['store_deliverycredit']['credit']) / 3), 1);
            $info['store_credit_percent'] = intval($info['store_credit_average'] / 5 * 100);

            if ($storeclass_id > 0) {
                $sc_info = $this->getEvaluatestoreInfoByScID($storeclass_id);
                foreach ($info['store_credit'] as $key => $value) {
                    if ($sc_info[$key]['credit'] > 0) {
                        $info['store_credit'][$key]['percent'] = intval(($info['store_credit'][$key]['credit'] - $sc_info[$key]['credit']) / $sc_info[$key]['credit'] * 100);
                    } else {
                        $info['store_credit'][$key]['percent'] = 0;
                    }
                    if ($info['store_credit'][$key]['percent'] > 0) {
                        $info['store_credit'][$key]['percent_class'] = 'high';
                        $info['store_credit'][$key]['percent_text'] = '高于';
                        $info['store_credit'][$key]['percent'] .= '%';
                    } elseif ($info['store_credit'][$key]['percent'] == 0) {
                        $info['store_credit'][$key]['percent_class'] = 'equal';
                        $info['store_credit'][$key]['percent_text'] = '持平';
                        $info['store_credit'][$key]['percent'] = '----';
                    } else {
                        $info['store_credit'][$key]['percent_class'] = 'low';
                        $info['store_credit'][$key]['percent_text'] = '低于';
                        $info['store_credit'][$key]['percent'] = abs($info['store_credit'][$key]['percent']);
                        $info['store_credit'][$key]['percent'] .= '%';
                    }
                }
            }
            $cache = array();
            $cache['evaluate'] = serialize($info);
            wcache($store_id, $cache, $prefix, 60 * 24);
        } else {
            $info = unserialize($info['evaluate']);
        }
        return $info;
    }

    /**
     * 根据分类编号获取分类评分数据
     * @access public
     * @author csdeshang
     * @param int $storeclass_id 店铺分类编号
     * @return array
     */
    public function getEvaluatestoreInfoByScID($storeclass_id) {
        $prefix = 'sc_evaluate_store_info';
        $info = rcache($storeclass_id, $prefix);
        if (empty($info)) {
            $store_model = model('store');
            $store_id_string = $store_model->getStoreIDString(array('storeclass_id' => $storeclass_id));
            $info = $this->_getEvaluatestore(array('seval_storeid' => array('in', $store_id_string)));
            $cache = array();
            $cache['evaluate_store_info'] = serialize($info);
            wcache($storeclass_id, $cache, $prefix, 60 * 24);
        } else {
            $info = unserialize($info['evaluate_store_info']);
        }
        return $info;
    }

    /**
     * 获取店铺评分数据
     * @access public
     * @author csdeshang
     * @param array $condition 查询条件
     * @return array
     */
    private function _getEvaluatestore($condition) {
        $result = array();
        $field = 'AVG(seval_desccredit) as store_desccredit,';
        $field .= 'AVG(seval_servicecredit) as store_servicecredit,';
        $field .= 'AVG(seval_deliverycredit) as store_deliverycredit,';
        $field .= 'COUNT(seval_id) as count';
        $info = $this->getEvaluatestoreInfo($condition, $field);
        $result['store_desccredit']['text'] = '描述相符';
        $result['store_servicecredit']['text'] = '服务态度';
        $result['store_deliverycredit']['text'] = '发货速度';
        if (intval($info['count']) > 0) {
            $result['store_desccredit']['credit'] = round($info['store_desccredit'], 1);
            $result['store_servicecredit']['credit'] = round($info['store_servicecredit'], 1);
            $result['store_deliverycredit']['credit'] = round($info['store_deliverycredit'], 1);
        } else {
            $result['store_desccredit']['credit'] = round(5, 1);
            $result['store_servicecredit']['credit'] = round(5, 1);
            $result['store_deliverycredit']['credit'] = round(5, 1);
        }
        return $result;
    }

    /**
     * 添加店铺评分
     * @access public
     * @author csdeshang
     * @param array $data 参数数据
     * @return type
     */
    public function addEvaluatestore($data) {
        return db('evaluatestore')->insertGetId($data);
    }

    /**
     * 删除店铺评分
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return type
     */
    public function delEvaluatestore($condition) {
        return db('evaluatestore')->where($condition)->delete();
    }

}
