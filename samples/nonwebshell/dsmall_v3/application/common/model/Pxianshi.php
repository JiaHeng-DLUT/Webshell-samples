<?php

/**
 * 限时折扣活动模型 
 *
 */

namespace app\common\model;

use think\Model;

class Pxianshi extends Model {

    public $page_info;
    const XIANSHI_STATE_NORMAL = 1;
    const XIANSHI_STATE_CLOSE = 2;
    const XIANSHI_STATE_CANCEL = 3;

    private $xianshi_state_array = array(
        0 => '全部',
        self::XIANSHI_STATE_NORMAL => '正常',
        self::XIANSHI_STATE_CLOSE => '已结束',
        self::XIANSHI_STATE_CANCEL => '管理员关闭'
    );

    /**
     * 读取限时折扣列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $page 分页
     * @param type $order 排序
     * @param type $field 字段
     * @return type
     */
    public function getXianshiList($condition, $page = null, $order = '', $field = '*') {
        $res = db('pxianshi')->field($field)->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
        $xianshi_list= $res->items();
        $this->page_info=$res;
        if (!empty($xianshi_list)) {
            for ($i = 0, $j = count($xianshi_list); $i < $j; $i++) {
                $xianshi_list[$i] = $this->getXianshiExtendInfo($xianshi_list[$i]);
            }
        }
        
        return $xianshi_list;
    }

    /**
     * 根据条件读取限制折扣信息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getXianshiInfo($condition) {
        $xianshi_info = db('pxianshi')->where($condition)->find();
        $xianshi_info = $this->getXianshiExtendInfo($xianshi_info);
        return $xianshi_info;
    }

    /**
     * 根据限时折扣编号读取限制折扣信息
     * @access public
     * @author csdeshang
     * @param type $xianshi_id 限制折扣活动编号
     * @param type $store_id 如果提供店铺编号，判断是否为该店铺活动，如果不是返回null
     * @return array
     */
    public function getXianshiInfoByID($xianshi_id, $store_id = 0) {
        if (intval($xianshi_id) <= 0) {
            return null;
        }

        $condition = array();
        $condition['xianshi_id'] = $xianshi_id;
        $xianshi_info = $this->getXianshiInfo($condition);
        if ($store_id > 0 && $xianshi_info['store_id'] != $store_id) {
            return null;
        } else {
            return $xianshi_info;
        }
    }

    /**
     * 限时折扣状态数组
     * @access public
     * @author csdeshang
     * @return type
     */
    public function getXianshiStateArray() {
        return $this->xianshi_state_array;
    }

    /**
     * 增加
     * @access public
     * @author csdeshang
     * @param array $data 数据
     * @return bool
     */
    public function addXianshi($data) {
        $data['xianshi_state'] = self::XIANSHI_STATE_NORMAL;
        return db('pxianshi')->insertGetId($data);
    }

    /**
     * 更新
     * @access public
     * @author csdeshang
     * @param type $update 数据
     * @param type $condition 条件
     * @return type
     */
    public function editXianshi($update, $condition) {
        return db('pxianshi')->where($condition)->update($update);
    }

    /**
     * 删除限时折扣活动，同时删除限时折扣商品
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return bool
     */
    public function delXianshi($condition) {
        $xianshi_list = $this->getXianshiList($condition);
        $xianshi_id_string = '';
        if (!empty($xianshi_list)) {
            foreach ($xianshi_list as $value) {
                $xianshi_id_string .= $value['xianshi_id'] . ',';
            }
        }

        //删除限时折扣商品
        if ($xianshi_id_string !== '') {
            $xianshigoods_model = model('pxianshigoods');
            $xianshigoods_model->delXianshigoods(array('xianshi_id' => array('in', $xianshi_id_string)));
        }

        return db('pxianshi')->where($condition)->delete();
    }

    /**
     * 取消限时折扣活动，同时取消限时折扣商品
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function cancelXianshi($condition) {
        $xianshi_list = $this->getXianshiList($condition);
        $xianshi_id_string = '';
        if (!empty($xianshi_list)) {
            foreach ($xianshi_list as $value) {
                $xianshi_id_string .= $value['xianshi_id'] . ',';
            }
        }

        $update = array();
        $update['xianshi_state'] = self::XIANSHI_STATE_CANCEL;

        //删除限时折扣商品
        if ($xianshi_id_string !== '') {
            $xianshigoods_model = model('pxianshigoods');
            $xianshigoods_model->editXianshigoods(array('xianshigoods_state'=>self::XIANSHI_STATE_CANCEL), array('xianshi_id' => array('in', $xianshi_id_string)));
        }

        return $this->editXianshi($update, $condition);
    }

    /**
     * 获取限时折扣扩展信息，包括状态文字和是否可编辑状态
     * @access public
     * @author csdeshang
     * @param type $xianshi_info 限时折扣信息
     * @return boolean
     */
    public function getXianshiExtendInfo($xianshi_info) {
        if ($xianshi_info['xianshi_end_time'] > TIMESTAMP) {
            $xianshi_info['xianshi_state_text'] = $this->xianshi_state_array[$xianshi_info['xianshi_state']];
        } else {
            $xianshi_info['xianshi_state_text'] = '已结束';
        }

        if ($xianshi_info['xianshi_state'] == self::XIANSHI_STATE_NORMAL && $xianshi_info['xianshi_end_time'] > TIMESTAMP) {
            $xianshi_info['editable'] = true;
        } else {
            $xianshi_info['editable'] = false;
        }

        return $xianshi_info;
    }

    /**
     * 编辑过期修改状态
     * @access public
     * @author csdeshang
     * @param type $condition
     * @return boolean
     */
    public function editExpireXianshi($condition) {
        $condition['xianshi_end_time'] = array('lt', TIMESTAMP);

        // 更新商品促销价格
        $xianshigoods_list = model('pxianshigoods')->getXianshigoodsList(array('xianshigoods_end_time'=>array('lt', TIMESTAMP)));
        if (!empty($xianshigoods_list)) {
            $goodsid_array = array();
            foreach ($xianshigoods_list as $val) {
                $goodsid_array[] = $val['goods_id'];
            }
            // 更新商品促销价格，需要考虑抢购是否在进行中
            \mall\queue\QueueClient::push('updateGoodsPromotionPriceByGoodsId', $goodsid_array);
        }
        $condition['xianshi_state'] = self::XIANSHI_STATE_NORMAL;

        $updata = array();
        $update['xianshi_state'] = self::XIANSHI_STATE_CLOSE;
        $this->editXianshi($update, $condition);
        return true;
    }

}
