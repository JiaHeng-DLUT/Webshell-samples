<?php

namespace app\common\model;
use think\Model;
use think\Db;
class Goods extends Model {

    const STATE1 = 1;       // 出售中
    const STATE0 = 0;       // 下架
    const STATE10 = 10;     // 违规
    const VERIFY1 = 1;      // 审核通过
    const VERIFY0 = 0;      // 审核失败
    const VERIFY10 = 10;    // 等待审核

    public $page_info;

    /**
     * 新增商品数据
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @return type
     */
    public function addGoods($data) {
        $result = db('goods')->insertGetId($data);
        if ($result) {
            $this->_dGoodsCache($result);
            $this->_dGoodsCommonCache($data['goods_commonid']);
            $this->_dGoodsSpecCache($data['goods_commonid']);
        }
        return $result;
    }

    /**
     * 新增商品公共数据
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @return type
     */
    public function addGoodsCommon($data) {
        return db('goodscommon')->insertGetId($data);
    }

    /**
     * 新增多条商品数据
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @return type
     */
    public function addGoodsImagesAll($data) {
        $result = db('goodsimages')->insertAll($data);
        if ($result) {
            foreach ($data as $val) {
                $this->_dGoodsImageCache($val['goods_commonid'] . '|' . $val['color_id']);
            }
        }
        return $result;
    }

    /**
     * 商品SKU列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @param type $group 分组
     * @param type $order 排序
     * @param type $limit 限制
     * @param type $page 分页
     * @param type $lock 是否锁定
     * @param type $count 计数
     * @return array
     */
    public function getGoodsList($condition, $field = '*', $group = '', $order = '', $limit = 0, $page = 0, $lock = false, $count = 0) {
        $condition = $this->_getRecursiveClass($condition);
        if ($page) {
            $result = db('goods')->field($field)->where($condition)->group($group)->order($order)->paginate($page,false,['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        } else {
            $result = db('goods')->field($field)->where($condition)->limit($limit)->group($group)->order($order)->select();
            return $result;
        }
    }

    /**
     * 获取指定分类指定店铺下的随机商品列表 
     * @access public
     * @author csdeshang
     * @param int $gcId 一级分类ID
     * @param int $storeId 店铺ID
     * @param int $notEqualGoodsId 此商品ID除外
     * @param int $size 列表最大长度
     * @return array|null
     */
    public function getGoodsGcStoreRandList($gcId, $storeId, $notEqualGoodsId = 0, $size = 4) {
        $where = array(
            'store_id' => (int) $storeId,
            'gc_id_1' => (int) $gcId,
        );
        if ($notEqualGoodsId > 0) {
            $where['goods_id'] = array('neq', (int) $notEqualGoodsId);
        }
        return db('goods')->where($where)->limit($size)->select();
    }

    /**
     * 出售中的商品SKU列表（只显示不同颜色的商品，前台商品索引，店铺也商品列表等使用）
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param string $field 字段
     * @param type $order 排序
     * @param type $page 分页
     * @param type $limit 限制
     * @return type
     */
    public function getGoodsListByColorDistinct($condition, $field = '*', $order = 'goods_id asc', $page = 0,$limit=0) {
        $condition['goods_state'] = self::STATE1;
        $condition['goods_verify'] = self::VERIFY1;
        $condition = $this->_getRecursiveClass($condition);

        $field = "CONCAT(goods_commonid) as nc_distinct ," . $field;
        $count = db('goods')->where($condition)->field("distinct CONCAT(goods_commonid)")->count();
        $goods_list = array();
        if ($count != 0) {
            $goods_list = $this->getGoodsOnlineList($condition, $field, $page, $order, $limit, 'CONCAT(goods_commonid)', false, $count);
        }
        return $goods_list;
    }

    /**
     * 在售商品SKU列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @param int $page 分页
     * @param string $order 排序
     * @return array
     */
    public function getGeneralGoodsList($condition, $field = '*', $page = 0, $order = 'goods_id desc') {
        $condition['is_virtual'] = 0;
        $condition['is_goodsfcode'] = 0;
        $condition['is_presell'] = 0;
        return $this->getGoodsList($condition, $field, '', $order, 0, $page, false, 0);
    }

    /**
     * 在售商品SKU列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param str $field 字段
     * @param int $page 分页
     * @param str $order 排序
     * @param int $limit 限制
     * @param str $group 分组
     * @param bool $lock 是否锁定
     * @param int $count 计数
     * @return array
     */
    public function getGoodsOnlineList($condition, $field = '*', $page = 0, $order = 'goods_id desc', $limit = 0, $group = '', $lock = false, $count = 0) {
        $condition['goods_state'] = self::STATE1;
        $condition['goods_verify'] = self::VERIFY1;
        return $this->getGoodsList($condition, $field, $group, $order, $limit, $page, $lock, $count);
    }

    /**
     * 出售中的普通商品列表，即不包括虚拟商品、F码商品、预售商品
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @param type $page 分页
     * @param type $type 类型
     * @return array
     */
    public function getGoodsListForPromotion($condition, $field = '*', $page = 0, $type = '') {
        switch ($type) {
            case 'xianshi':
            case 'bundling':
            case 'combo':
                $condition['is_virtual'] = 0;
                $condition['is_goodsfcode'] = 0;
                $condition['is_presell'] = 0;
                $condition['goods_state'] = self::STATE1;
                $condition['goods_verify'] = self::VERIFY1;
                break;
            case 'gift':
                $condition['is_virtual'] = 0;
                break;
            default:
                break;
        }
        return $this->getGoodsList($condition, $field, '', '', 0, $page);
    }

    /**
     * 商品列表 卖家中心使用
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $field 字段
     * @param string $page 分页
     * @param string $order 排序
     * @return array
     */
    public function getGoodsCommonList($condition, $field = '*', $page = 10, $order = 'goods_commonid desc') {
        $condition = $this->_getRecursiveClass($condition);
        if ($page) {
            $result = db('goodscommon')->field($field)->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        } else {
            return db('goodscommon')->field($field)->where($condition)->order($order)->select();
        }
    }

    /**
     * 出售中的商品列表 卖家中心使用
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $field 字段
     * @param string $page 分页
     * @param string $order 排序
     * @return array
     */
    public function getGoodsCommonOnlineList($condition, $field = '*', $page = 10, $order = "goods_commonid desc") {
        $condition['goods_state'] = self::STATE1;
        $condition['goods_verify'] = self::VERIFY1;
        return $this->getGoodsCommonList($condition, $field, $page, $order);
    }

    /**
     * 出售中的普通商品列表，即不包括虚拟商品、F码商品、预售商品
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param str $field 字段
     * @param int $page 分页
     * @param str $type 排序
     * @return array
     */
    public function getGoodsCommonListForPromotion($condition, $field = '*', $page = 10, $type) {
        if ($type == 'groupbuy') {
            $condition['is_virtual'] = 0;
            $condition['is_goodsfcode'] = 0;
            $condition['is_presell'] = 0;
            $condition['goods_state'] = self::STATE1;
            $condition['goods_verify'] = self::VERIFY1;
        }
        return $this->getGoodsCommonList($condition, $field, $page);
    }

    /**
     * 出售中的未参加促销的虚拟商品列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param str $field 字段
     * @param int $page 分页
     * @return array
     */
    public function getGoodsCommonListForVrPromotion($condition, $field = '*', $page = 10) {
        $condition['is_virtual'] = 1;
        $condition['is_goodsfcode'] = 0;
        $condition['is_presell'] = 0;
        $condition['goods_state'] = self::STATE1;
        $condition['goods_verify'] = self::VERIFY1;

        return $this->getGoodsCommonList($condition, $field, $page);
    }

    /**
     * 仓库中的商品列表 卖家中心使用
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $field 字段
     * @param string $page 分页
     * @param string $order 排序
     * @return array
     */
    public function getGoodsCommonOfflineList($condition, $field = '*', $page = 10, $order = "goods_commonid desc") {
        $condition['goods_state'] = self::STATE0;
        $condition['goods_verify'] = self::VERIFY1;
        return $this->getGoodsCommonList($condition, $field, $page, $order);
    }

    /**
     * 违规的商品列表 卖家中心使用
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $field 字段
     * @param string $page 分页
     * @param string $order 排序
     * @return array
     */
    public function getGoodsCommonLockUpList($condition, $field = '*', $page = 10, $order = "goods_commonid desc") {
        $condition['goods_state'] = self::STATE10;
        $condition['goods_verify'] = self::VERIFY1;
        return $this->getGoodsCommonList($condition, $field, $page, $order);
    }

    /**
     * 等待审核或审核失败的商品列表 卖家中心使用
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $field 字段
     * @param string $page 分页
     * @param string $order 排序
     * @return array
     */
    public function getGoodsCommonWaitVerifyList($condition, $field = '*', $page = 10, $order = "goods_commonid desc") {
        if (!isset($condition['goods_verify'])) {
            $condition['goods_verify'] = array('neq', self::VERIFY1);
        }
        return $this->getGoodsCommonList($condition, $field, $page, $order);
    }

    /**
     * 查询商品SUK及其店铺信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return array
     */
    public function getGoodsStoreList($condition, $field = '*') {
        $condition = $this->_getRecursiveClass($condition);
        return db('goods')->alias('goods')->field($field)->join('__STORE__ store','goods.store_id = store.store_id','inner')->where($condition)->select();
    }

    /**
     * 查询推荐商品(随机排序) 
     * @access public
     * @author csdeshang
     * @param int $store_id 店铺
     * @param int $limit 限制
     * @return array
     */
    public function getGoodsCommendList($store_id, $limit = 5) {
        $goods_commend_list = $this->getGoodsOnlineList(array('store_id' => $store_id, 'goods_commend' => 1), 'goods_id,goods_name,goods_advword,goods_image,store_id,goods_promotion_price,goods_price', 0, '', $limit, 'goods_commonid');
        if (!empty($goods_id_list)) {
            $tmp = array();
            foreach ($goods_id_list as $v) {
                $tmp[] = $v['goods_id'];
            }
            $goods_commend_list = $this->getGoodsOnlineList(array('goods_id' => array('in', $tmp)), 'goods_id,goods_name,goods_advword,goods_image,store_id,goods_promotion_price', 0, '', $limit);
        }
        return $goods_commend_list;
    }

    /**
     * 计算商品库存
     * @access public
     * @author csdeshang
     * @param array $goods_list 商品列表
     * @return array|boolean
     */
    public function calculateStorage($goods_list) {
        // 计算库存
        if (!empty($goods_list)) {
            $goodsid_array = array();
            foreach ($goods_list as $value) {
                $goodscommonid_array[] = $value['goods_commonid'];
            }
            $goods_storage = $this->getGoodsList(array('goods_commonid' => array('in', $goodscommonid_array)), 'goods_storage,goods_commonid,goods_id,goods_storage_alarm');
            $storage_array = array();
            foreach ($goods_storage as $val) {
                if ($val['goods_storage_alarm'] != 0 && $val['goods_storage'] <= $val['goods_storage_alarm']) {
                    $storage_array[$val['goods_commonid']]['alarm'] = true;
                }
                //初始化
                if (!isset($storage_array[$val['goods_commonid']]['sum'])) {
                    $storage_array[$val['goods_commonid']]['sum'] = 0;
                }
                $storage_array[$val['goods_commonid']]['sum'] += $val['goods_storage'];
                $storage_array[$val['goods_commonid']]['goods_id'] = $val['goods_id'];
            }
            return $storage_array;
        } else {
            return false;
        }
    }

    /**
     * 更新商品SUK数据
     * @access public
     * @author csdeshang
     * @param array $update 更新数据
     * @param array $condition 条件
     * @return boolean
     */
    public function editGoods($update, $condition) {
        $goods_list = $this->getGoodsList($condition, 'goods_id');
        if (empty($goods_list)) {
            return true;
        }
        $goodsid_array = array();
        foreach ($goods_list as $value) {
            $goodsid_array[] = $value['goods_id'];
        }
        return $this->editGoodsById($update, $goodsid_array);
    }

    /**
     * 更新商品SUK数据
     * @access public
     * @author csdeshang
     * @param array $update 更新数据
     * @param int|array $goodsid_array 商品ID
     * @return boolean|unknown
     */
    public function editGoodsById($update, $goodsid_array) {
        if (empty($goodsid_array)) {
            return true;
        }
        $condition['goods_id'] = array('in', $goodsid_array);
        $update['goods_edittime'] = TIMESTAMP;
        $result = db('goods')->where($condition)->update($update);
        if ($result) {
            foreach ((array) $goodsid_array as $value) {
                $this->_dGoodsCache($value);
            }
        }
        return $result;
    }

    /**
     * 更新商品促销价 (需要验证抢购和限时折扣是否进行)
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function editGoodsPromotionPrice($condition) {
        $goods_list = $this->getGoodsList($condition, 'goods_id,goods_commonid');
        $goods_array = array();
        foreach ($goods_list as $val) {
            $goods_array[$val['goods_commonid']][$val['goods_id']] = $val;
        }
        $groupbuy_model = model('groupbuy');
        $pxianshigoods_model = model('pxianshigoods');
        foreach ($goods_array as $key => $val) {
            // 查询抢购时候进行
            $groupbuy = $groupbuy_model->getGroupbuyOnlineInfo(array('goods_commonid' => $key));
            if (!empty($groupbuy)) {
                // 更新价格
                $this->editGoods(array('goods_promotion_price' => $groupbuy['groupbuy_price'], 'goods_promotion_type' => 1), array('goods_commonid' => $key));
                continue;
            }
            foreach ($val as $k => $v) {
                // 查询限时折扣时候进行
                $xianshigoods = $pxianshigoods_model->getXianshigoodsInfo(array('goods_id' => $k, 'xianshigoods_starttime' => array('lt', TIMESTAMP), 'xianshigoods_end_time' => array('gt', TIMESTAMP)));
                if (!empty($xianshigoods)) {
                    // 更新价格
                    $this->editGoodsById(array('goods_promotion_price' => $xianshigoods['xianshigoods_price'], 'goods_promotion_type' => 2), $k);
                    continue;
                }

                // 没有促销使用原价
                $this->editGoodsById(array('goods_promotion_price' => Db::raw('goods_price'), 'goods_promotion_type' => 0), $k);
            }
        }
        return true;
    }

    /**
     * 更新商品数据
     * @access public
     * @author csdeshang
     * @param array $update 更新数据
     * @param array $condition 条件
     * @return boolean
     */
    public function editGoodsCommon($update, $condition) {
        $common_list = $this->getGoodsCommonList($condition, 'goods_commonid', 0);
        if (empty($common_list)) {
            return false;
        }
        $commonid_array = array();
        foreach ($common_list as $val) {
            $commonid_array[] = $val['goods_commonid'];
        }
        return $this->editGoodsCommonById($update, $commonid_array);
    }

    /**
     * 更新商品数据
     * @access public
     * @author csdeshang
     * @param array $update 更新数据
     * @param int|array $commonid_array 商品ID
     * @return boolean|unknown
     */
    public function editGoodsCommonById($update, $commonid_array) {
        if (empty($commonid_array)) {
            return true;
        }
        $condition['goods_commonid'] = array('in', $commonid_array);
        $result = db('goodscommon')->where($condition)->update($update);
        if ($result) {
            foreach ((array) $commonid_array as $val) {
                $this->_dGoodsCommonCache($val);
            }
        }
        return $result;
    }

    /**
     * 锁定商品
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function editGoodsCommonLock($condition) {
        $update = array('goods_lock' => 1);
        return $this->editGoodsCommon($update, $condition);
    }

    /**
     * 解锁商品
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function editGoodsCommonUnlock($condition) {
        $update = array('goods_lock' => 0);
        return $this->editGoodsCommon($update, $condition);
    }

    /**
     * 更新商品信息
     * @access public
     * @author csdeshang
     * @param array $condition 更新条件
     * @param array $update1 更新数据1
     * @param array $update2 更新数据2
     * @return boolean
     */
    public function editProduces($condition, $update1, $update2 = array()) {
        $update2 = empty($update2) ? $update1 : $update2;
        $goods_array = $this->getGoodsCommonList($condition, 'goods_commonid', 0);
        if (empty($goods_array)) {
            return true;
        }
        $commonid_array = array();
        foreach ($goods_array as $val) {
            $commonid_array[] = $val['goods_commonid'];
        }
        $return1 = $this->editGoodsCommonById($update1, $commonid_array);
        $return2 = $this->editGoods($update2, array('goods_commonid' => array('in', $commonid_array)));
        if ($return1 && $return2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 更新商品信息（审核失败）
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $update1 更新数据1
     * @param array $update2 更新数据2
     * @return boolean
     */
    public function editProducesVerifyFail($condition, $update1, $update2 = array()) {
        $result = $this->editProduces($condition, $update1, $update2);
        if ($result) {
            $commonlist = $this->getGoodsCommonList($condition, 'goods_commonid,store_id,goods_verifyremark', 0);
            foreach ($commonlist as $val) {
                $message = array();
                $message['common_id'] = $val['goods_commonid'];
                $message['remark'] = $val['goods_verifyremark'];
                $this->_sendStoremsg('goods_verify', $val['store_id'], $message);
            }
        }
    }

    /**
     * 更新未锁定商品信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $update1 更新数据1
     * @param array $update2 更新数据2
     * @return boolean
     */
    public function editProducesNoLock($condition, $update1, $update2 = array()) {
        $condition['goods_lock'] = 0;
        return $this->editProduces($condition, $update1, $update2);
    }

    /**
     * 商品下架
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function editProducesOffline($condition) {
        $update = array('goods_state' => self::STATE0);
        return $this->editProducesNoLock($condition, $update);
    }

    /**
     * 商品上架
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function editProducesOnline($condition) {
        $update = array('goods_state' => self::STATE1);
        // 禁售商品、审核失败商品不能上架。
        $condition['goods_state'] = self::STATE0;
        $condition['goods_verify'] = array('neq', self::VERIFY0);
        // 修改预约商品状态
        $update['is_appoint'] = 0;
        return $this->editProduces($condition, $update);
    }

    /**
     * 违规下架
     * @access public
     * @author csdeshang
     * @param array $update 数据
     * @param array $condition 条件
     * @return boolean
     */
    public function editProducesLockUp($update, $condition) {
        $update_param['goods_state'] = self::STATE10;
        $update = array_merge($update, $update_param);
        $return = $this->editProduces($condition, $update, $update_param);
        if ($return) {
            // 商品违规下架发送店铺消息
            $common_list = $this->getGoodsCommonList($condition, 'goods_commonid,store_id,goods_stateremark', 0);
            foreach ($common_list as $val) {
                $message = array();
                $message['remark'] = $val['goods_stateremark'];
                $message['common_id'] = $val['goods_commonid'];
                $this->_sendStoremsg('goods_violation', $val['store_id'], $message);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取单条商品SKU信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return array
     */
    public function getGoodsInfo($condition, $field = '*') {

        return db('goods')->field($field)->where($condition)->find();
    }

  
    /**
     * 获取单条商品SKU信息及其促销信息
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品ID
     * @return type
     */
    public function getGoodsOnlineInfoForShare($goods_id) {
        $goods_info = $this->getGoodsOnlineInfoAndPromotionById($goods_id);
        if (empty($goods_info)) {
            return array();
        }
        //抢购
        if (!empty($goods_info['groupbuy_info'])) {
            $goods_info['promotion_type'] = '抢购';
            $goods_info['promotion_price'] = $goods_info['groupbuy_info']['groupbuy_price'];
        }

        if (!empty($goods_info['xianshi_info'])) {
            $goods_info['promotion_type'] = '限时折扣';
            $goods_info['promotion_price'] = $goods_info['xianshi_info']['xianshigoods_price'];
        }
        return $goods_info;
    }

    /**
     * 查询出售中的商品详细信息及其促销信息
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品ID
     * @return array
     */
    public function getGoodsOnlineInfoAndPromotionById($goods_id) {
        $goods_info = $this->getGoodsInfoAndPromotionById($goods_id);
        if (empty($goods_info) || $goods_info['goods_state'] != self::STATE1 || $goods_info['goods_verify'] != self::VERIFY1) {
            return array();
        }
        return $goods_info;
    }

    /**
     * 查询商品详细信息及其促销信息
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品ID
     * @return array
     */
    public function getGoodsInfoAndPromotionById($goods_id) {
        $goods_info = $this->getGoodsInfoByID($goods_id);
        if (empty($goods_info)) {
            return array();
        }
        $goods_info['groupbuy_info'] = '';
        $goods_info['pintuan_info'] = '';
        $goods_info['xianshi_info'] = '';
        $goods_info['mgdiscount_info'] = '';
        
        
        //抢购
        if (config('groupbuy_allow')) {
            $goods_info['groupbuy_info'] = model('groupbuy')->getGroupbuyInfoByGoodsCommonID($goods_info['goods_commonid']);
        }
        
        //拼团
        if (empty($goods_info['groupbuy_info'])) {
            $goods_info['pintuan_info'] = model('ppintuan')->getPintuanInfoByGoodsCommonID($goods_info['goods_commonid']);
        }

        //限时折扣
        if (empty($goods_info['groupbuy_info']) && empty($goods_info['pintuan_info'])) {
            if (config('promotion_allow') && empty($goods_info['groupbuy_info'])) {
                $goods_info['xianshi_info'] = model('pxianshigoods')->getXianshigoodsInfoByGoodsID($goods_info['goods_id']);
            }
        }

        //会员等级折扣
        if (empty($goods_info['groupbuy_info']) && empty($goods_info['pintuan_info']) && empty($goods_info['xianshi_info'])) {
            if (config('mgdiscount_allow')) {
                $goods_info['mgdiscount_info'] = model('pmgdiscount')->getPmgdiscountInfoByGoodsInfo($goods_info);
            }
        }

        return $goods_info;
    }

    /**
     * 查询出售中的商品列表及其促销信息
     * @access public
     * @author csdeshang
     * @param array $goodsid_array 商品ID数组
     * @return array
     */
    public function getGoodsOnlineListAndPromotionByIdArray($goodsid_array) {
        if (empty($goodsid_array) || !is_array($goodsid_array))
            return array();

        $goods_list = array();
        foreach ($goodsid_array as $goods_id) {
            $goods_info = $this->getGoodsOnlineInfoAndPromotionById($goods_id);
            if (!empty($goods_info))
                $goods_list[] = $goods_info;
        }

        return $goods_list;
    }

    /**
     * 获取单条商品信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return array
     */
    public function getGoodeCommonInfo($condition, $field = '*') {
        return db('goodscommon')->field($field)->where($condition)->find();
    }

    /**
     * 取得商品详细信息（优先查询缓存）
     * @access public
     * @author csdeshang
     * @param int $goods_commonid 商品ID
     * @return array
     */
    public function getGoodeCommonInfoByID($goods_commonid) {
        $common_info = $this->_rGoodsCommonCache($goods_commonid);
        if (empty($common_info)) {
            $common_info = $this->getGoodeCommonInfo(array('goods_commonid' => $goods_commonid));
            $this->_wGoodsCommonCache($goods_commonid, $common_info);
        }
        return $common_info;
    }

    /**
     * 获得商品SKU某字段的和
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return boolean
     */
    public function getGoodsSum($condition, $field) {
        return db('goods')->where($condition)->sum($field);
    }

    /**
     * 获得商品SKU数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getGoodsCount($condition) {
        return db('goods')->where($condition)->count();
    }

    /**
     * 获得出售中商品SKU数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return int
     */
    public function getGoodsOnlineCount($condition, $field = '*') {
        $condition['goods_state'] = self::STATE1;
        $condition['goods_verify'] = self::VERIFY1;
        return db('goods')->where($condition)->count($field);
    }

    /**
     * 获得商品数量
     * @access public
     * @author csdeshang
     * @param array $condition
     * @return int
     */
    public function getGoodsCommonCount($condition) {
        return db('goodscommon')->where($condition)->count();
    }

    /**
     * 出售中的商品数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getGoodsCommonOnlineCount($condition) {
        $condition['goods_state'] = self::STATE1;
        $condition['goods_verify'] = self::VERIFY1;
        return $this->getGoodsCommonCount($condition);
    }

    /**
     * 仓库中的商品数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getGoodsCommonOfflineCount($condition) {
        $condition['goods_state'] = self::STATE0;
        $condition['goods_verify'] = self::VERIFY1;
        return $this->getGoodsCommonCount($condition);
    }

    /**
     * 等待审核的商品数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getGoodsCommonWaitVerifyCount($condition) {
        $condition['goods_verify'] = self::VERIFY10;
        return $this->getGoodsCommonCount($condition);
    }

    /**
     * 审核失败的商品数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getGoodsCommonVerifyFailCount($condition) {
        $condition['goods_verify'] = self::VERIFY0;
        return $this->getGoodsCommonCount($condition);
    }

    /**
     * 违规下架的商品数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getGoodsCommonLockUpCount($condition) {
        $condition['goods_state'] = self::STATE10;
        $condition['goods_verify'] = self::VERIFY1;
        return $this->getGoodsCommonCount($condition);
    }

    /**
     * 商品图片列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $order 字段
     * @param string $field 排序
     * @return array
     */
    public function getGoodsImageList($condition, $field = '*', $order = 'goodsimage_isdefault desc,goodsimage_sort asc') {
        return db('goodsimages')->field($field)->where($condition)->order($order)->select();
    }

    /**
     * 删除商品SKU信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function delGoods($condition) {
        $goods_list = $this->getGoodsList($condition, 'goods_id,goods_commonid,store_id');
        if (!empty($goods_list)) {
            $goodsid_array = array();
            // 删除商品二维码
            foreach ($goods_list as $val) {
                $goodsid_array[] = $val['goods_id'];
                @unlink(BASE_UPLOAD_PATH . DS . ATTACH_STORE . DS . $val['store_id'] . DS . $val['goods_id'] . '.png');
                // 删除商品缓存
                $this->_dGoodsCache($val['goods_id']);
                // 删除商品规格缓存
                $this->_dGoodsSpecCache($val['goods_commonid']);
            }
            // 删除属性关联表数据
            db('goodsattrindex')->where(array('goods_id' => array('in', $goodsid_array)))->delete();
            // 删除优惠套装商品
            model('pbundling')->delBundlingGoods(array('goods_id' => array('in', $goodsid_array)));
            // 优惠套餐活动下架
            model('pbundling')->editBundlingCloseByGoodsIds(array('goods_id' => array('in', $goodsid_array)));
            // 推荐展位商品
            model('pbooth')->delBoothgoods(array('goods_id' => array('in', $goodsid_array)));
            // 限时折扣
            model('pxianshigoods')->delXianshigoods(array('goods_id' => array('in', $goodsid_array)));
            //删除商品浏览记录
            model('goodsbrowse')->delGoodsbrowse(array('goods_id' => array('in', $goodsid_array)));
            // 删除买家收藏表数据
            model('favorites')->delFavorites(array('fav_id' => array('in', $goodsid_array), 'fav_type' => 'goods'));
            // 删除商品赠品
            model('goodsgift')->delGoodsgift(array('goods_id' => array('in', $goodsid_array)));
            model('goodsgift')->delGoodsgift(array('gift_goodsid' => array('in', $goodsid_array)));
            // 删除推荐组合
            model('goodscombo')->delGoodscombo(array('goods_id' => array('in', $goodsid_array)));
            model('goodscombo')->delGoodscombo(array('combo_goodsid' => array('in', $goodsid_array)));
        }
        return db('goods')->where($condition)->delete();
    }

    /**
     * 删除商品图片表信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function delGoodsImages($condition) {
        $image_list = $this->getGoodsImageList($condition, 'goods_commonid,color_id');
        if (empty($image_list)) {
            return true;
        }
        $result = db('goodsimages')->where($condition)->delete();
        if ($result) {
            foreach ($image_list as $val) {
                $this->_dGoodsImageCache($val['goods_commonid'] . '|' . $val['color_id']);
            }
        }
        return $result;
    }

    /**
     * 商品删除及相关信息
     * @access public
     * @author csdeshang
     * @param  array $condition 列表条件
     * @return boolean
     */
    public function delGoodsAll($condition) {
        $goods_list = $this->getGoodsList($condition, 'goods_id,goods_commonid,store_id');
        if (empty($goods_list)) {
            return false;
        }
        $goodsid_array = array();
        $commonid_array = array();
        foreach ($goods_list as $val) {
            $goodsid_array[] = $val['goods_id'];
            $commonid_array[] = $val['goods_commonid'];
            // 商品公共缓存
            $this->_dGoodsCommonCache($val['goods_commonid']);
            // 商品规格缓存
            $this->_dGoodsSpecCache($val['goods_commonid']);
        }
        $commonid_array = array_unique($commonid_array);

        // 删除商品表数据
        $this->delGoods(array('goods_id' => array('in', $goodsid_array)));
        // 删除商品公共表数据
        db('goodscommon')->where(array('goods_commonid' => array('in', $commonid_array)))->delete();
        // 删除商品图片表数据
        $this->delGoodsImages(array('goods_commonid' => array('in', $commonid_array)));
        // 删除商品F码

        model('goodsfcode')->delGoodsfcode(array('goods_commonid' => array('in', $commonid_array)));

        return true;
    }

    /**删除未锁定商品
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return type
     */
    public function delGoodsNoLock($condition) {
        $condition['goods_lock'] = 0;
        $common_array = $this->getGoodsCommonList($condition, 'goods_commonid', 0);
        $common_array = array_under_reset($common_array, 'goods_commonid');
        $commonid_array = array_keys($common_array);
        return $this->delGoodsAll(array('goods_commonid' => array('in', $commonid_array)));
    }

    /**
     * 发送店铺消息
     * @access public
     * @author csdeshang
     * @param string $code 编码
     * @param int $store_id 店铺OD
     * @param array $param 参数
     */
    private function _sendStoremsg($code, $store_id, $param) {
        \mall\queue\QueueClient::push('sendStoremsg', array('code' => $code, 'store_id' => $store_id, 'param' => $param));
    }

    /**
     * 获得商品子分类的ID
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return array
     */
    private function _getRecursiveClass($condition) {
        if (isset($condition['gc_id']) && !is_array($condition['gc_id'])) {
            $gc_list = model('goodsclass')->getGoodsclassForCacheModel();
            if (!empty($gc_list[$condition['gc_id']])) {
                $gc_id[] = $condition['gc_id'];
                $gcchild_id = empty($gc_list[$condition['gc_id']]['child']) ? array() : explode(',', $gc_list[$condition['gc_id']]['child']);
                $gcchildchild_id = empty($gc_list[$condition['gc_id']]['childchild']) ? array() : explode(',', $gc_list[$condition['gc_id']]['childchild']);
                $gc_id = array_merge($gc_id, $gcchild_id, $gcchildchild_id);
                $condition['gc_id'] = array('in', $gc_id);
            }
        }
        return $condition;
    }

    /**
     * 由ID取得在售单个虚拟商品信息
     * @access public
     * @author csdeshang
     * @param array $goods_id 商品ID
     * @return array
     */
    public function getVirtualGoodsOnlineInfoByID($goods_id) {
        $goods_info = $this->getGoodsInfoByID($goods_id);
        return $goods_info['is_virtual'] == 1 && $goods_info['virtual_indate'] >= TIMESTAMP ? $goods_info : array();
    }

    /**
     * 取得商品详细信息（优先查询缓存）（在售）
     * 如果未找到，则缓存所有字段
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品ID
     * @return array
     */
    public function getGoodsOnlineInfoByID($goods_id) {
        $goods_info = $this->getGoodsInfoByID($goods_id);
        if ($goods_info['goods_state'] != self::STATE1 || $goods_info['goods_verify'] != self::VERIFY1) {
            $goods_info = array();
        }
        return $goods_info;
    }

    /**
     * 取得商品详细信息（优先查询缓存）
     * 如果未找到，则缓存所有字段
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品ID
     * @return array
     */
    public function getGoodsInfoByID($goods_id) {
        $goods_info = $this->_rGoodsCache($goods_id);
        if (empty($goods_info)) {
            $goods_info = $this->getGoodsInfo(array('goods_id' => $goods_id));
            $this->_wGoodsCache($goods_id, $goods_info);
        }
        return $goods_info;
    }

    /**
     * 验证是否为普通商品
     * @access public
     * @author csdeshang
     * @param array $goods 商品数组
     * @return boolean
     */
    public function checkIsGeneral($goods) {
        if ($goods['is_virtual'] == 1 || $goods['is_goodsfcode'] == 1 || $goods['is_presell'] == 1) {
            return false;
        }
        return true;
    }

    /**
     * 验证是否允许送赠品
     * @access public
     * @author csdeshang
     * @param type $goods 商品
     * @return boolean
     */
    public function checkGoodsIfAllowGift($goods) {
        if ($goods['is_virtual'] == 1) {
            return false;
        }
        return true;
    }
    /**
     * 验证是否允许关联套餐
     * @access public
     * @author csdeshang
     * @param type $goods 商品
     * @return boolean
     */
    public function checkGoodsIfAllowCombo($goods) {
        if ($goods['is_virtual'] == 1 || $goods['is_goodsfcode'] == 1 || $goods['is_presell'] == 1 || $goods['is_appoint'] == 1) {
            return false;
        }
        return true;
    }

    /**
     * 获得商品规格数组
     * @access public
     * @author csdeshang
     * @param type $common_id ID编号
     * @return type
     */
    public function getGoodsSpecListByCommonId($common_id) {
        $spec_list = $this->_rGoodsSpecCache($common_id);
        if (empty($spec_list)) {
            $spec_array = $this->getGoodsList(array('goods_commonid' => $common_id), 'goods_spec,goods_id,store_id,goods_image,color_id');
            $spec_list['spec'] = serialize($spec_array);
            $this->_wGoodsSpecCache($common_id, $spec_list);
        }
        $spec_array = unserialize($spec_list['spec']);
        return $spec_array;
    }

    /**
     * 获得商品图片数组
     * @access public
     * @author csdeshang
     * @param type $key 键值
     * @return type
     */
    public function getGoodsImageByKey($key) {
        $image_list = $this->_rGoodsImageCache($key);
        if (empty($image_list)) {
            $array = explode('|', $key);
            list($common_id, $color_id) = $array;
            $image_more = $this->getGoodsImageList(array('goods_commonid' => $common_id, 'color_id' => $color_id), 'goodsimage_url');
            $image_list['image'] = serialize($image_more);
            $this->_wGoodsImageCache($key, $image_list);
        }
        $image_more = unserialize($image_list['image']);
        return $image_more;
    }

    /**
     * 读取商品缓存
     * @access public
     * @author csdeshang
     * @param type $goods_id 商品id
     * @return type
     */
    private function _rGoodsCache($goods_id) {
        return rcache($goods_id, 'goods');
    }

    /**
     * 写入商品缓存
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品id
     * @param array $goods_info 商品信息
     * @return boolean
     */
    private function _wGoodsCache($goods_id, $goods_info) {
        return wcache($goods_id, $goods_info, 'goods');
    }

    /**
     * 删除商品缓存
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品id
     * @return boolean
     */
    private function _dGoodsCache($goods_id) {
        return dcache($goods_id, 'goods');
    }

    /**
     * 读取商品公共缓存
     * @access public
     * @author csdeshang
     * @param int $goods_commonid 商品id
     * @return array
     */
    private function _rGoodsCommonCache($goods_commonid) {
        return rcache($goods_commonid, 'goodscommon');
    }

    /**
     * 写入商品公共缓存
     * @access public
     * @author csdeshang
     * @param int $goods_commonid 商品ID
     * @param array $common_info 商品信息
     * @return boolean
     */
    private function _wGoodsCommonCache($goods_commonid, $common_info) {
        return wcache($goods_commonid, $common_info, 'goodscommon');
    }

    /**
     * 删除商品公共缓存
     * @access public
     * @author csdeshang
     * @param int $goods_commonid 商品ID
     * @return boolean
     */
    private function _dGoodsCommonCache($goods_commonid) {
        return dcache($goods_commonid, 'goodscommon');
    }

    /**
     * 读取商品规格缓存
     * @access public
     * @author csdeshang
     * @param int $goods_commonid 商品id
     * @return array
     */
    private function _rGoodsSpecCache($goods_commonid) {
        return rcache($goods_commonid, 'goods_spec');
    }

    /**
     * 写入商品规格缓存
     * @access public
     * @author csdeshang
     * @param int $goods_commonid 商品id
     * @param array $spec_list 规格列表
     * @return boolean
     */
    private function _wGoodsSpecCache($goods_commonid, $spec_list) {
        return wcache($goods_commonid, $spec_list, 'goods_spec');
    }

    /**
     * 删除商品规格缓存
     * @access public
     * @author csdeshang
     * @param int $goods_commonid 商品id
     * @return boolean
     */
    private function _dGoodsSpecCache($goods_commonid) {
        return dcache($goods_commonid, 'goods_spec');
    }

    /**
     * 读取商品图片缓存
     * @access public
     * @author csdeshang
     * @param int $key ($goods_commonid .'|'. $color_id)
     * @return array
     */
    private function _rGoodsImageCache($key) {
        return rcache($key, 'goods_image');
    }

    /**
     * 写入商品图片缓存
     * @access public
     * @author csdeshang
     * @param int $key ($goods_commonid .'|'. $color_id)
     * @param array $image_list 图片列表
     * @return boolean
     */
    private function _wGoodsImageCache($key, $image_list) {
        return wcache($key, $image_list, 'goods_image');
    }

    /**
     * 删除商品图片缓存
     * @access public
     * @author csdeshang
     * @param int $key ($goods_commonid .'|'. $color_id)
     * @return boolean
     */
    private function _dGoodsImageCache($key) {
        return dcache($key, 'goods_image');
    }

    /**
     * 获取单条商品信息
     * @access public
     * @author csdeshang
     * @param int $goods_id 商品ID 
     * @return array
     */
    public function getGoodsDetail($goods_id) {
        if ($goods_id <= 0) {
            return null;
        }
        $result1 = $this->getGoodsInfoAndPromotionById($goods_id);

        if (empty($result1)) {
            return null;
        }
        $result2 = $this->getGoodeCommonInfoByID($result1['goods_commonid']);
        $goods_info = array_merge($result2, $result1);

        $goods_info['spec_value'] = unserialize($goods_info['spec_value']);
        $goods_info['spec_name'] = unserialize($goods_info['spec_name']);
        $goods_info['goods_spec'] = unserialize($goods_info['goods_spec']);
        $goods_info['goods_attr'] = unserialize($goods_info['goods_attr']);

        // 手机商品描述
        if ($goods_info['mobile_body'] != '') {
            $mobile_body_array = unserialize($goods_info['mobile_body']);
            if (is_array($mobile_body_array)) {
                $mobile_body = '';
                foreach ($mobile_body_array as $val) {
                    switch ($val['type']) {
                        case 'text':
                            $mobile_body .= '<div>' . $val['value'] . '</div>';
                            break;
                        case 'image':
                            $mobile_body .= '<img src="' . $val['value'] . '">';
                            break;
                    }
                }
                $goods_info['mobile_body'] = $mobile_body;
            }
        }

        // 查询所有规格商品
        $spec_array = $this->getGoodsSpecListByCommonId($goods_info['goods_commonid']);
        $spec_list = array();       // 各规格商品地址，js使用
        $spec_list_mobile = array();       // 各规格商品地址，js使用
        $spec_image = array();      // 各规格商品主图，规格颜色图片使用
        foreach ($spec_array as $key => $value) {
            $s_array = unserialize($value['goods_spec']);
            $tmp_array = array();
            if (!empty($s_array) && is_array($s_array)) {
                foreach ($s_array as $k => $v) {
                    $tmp_array[] = $k;
                }
            }
            sort($tmp_array);
            $spec_sign = implode('|', $tmp_array);
            $tpl_spec = array();
            $tpl_spec['sign'] = $spec_sign;
            $tpl_spec['url'] = url('Home/Goods/index', ['goods_id' => $value['goods_id']]);
            $spec_list[] = $tpl_spec;
            $spec_list_mobile[$spec_sign] = $value['goods_id'];
            $spec_image[$value['color_id']] = goods_thumb($value, 240);
        }
        $spec_list = json_encode($spec_list);

        // 商品多图
        $image_more = $this->getGoodsImageByKey($goods_info['goods_commonid'] . '|' . $goods_info['color_id']);
        $goods_image = array();
        $goods_image_mobile = array();
        if (!empty($image_more)) {
            foreach ($image_more as $val) {
                $goods_image[] = array(goods_cthumb($val['goodsimage_url'], 240, $goods_info['store_id']), goods_cthumb($val['goodsimage_url'], 480, $goods_info['store_id']), goods_cthumb($val['goodsimage_url'], 1280, $goods_info['store_id']));
                $goods_image_mobile[] = goods_cthumb($val['goodsimage_url'], 480, $goods_info['store_id']);
            }
        } else {
            $goods_image[] = array(goods_thumb($goods_info,240),goods_thumb($goods_info,480),goods_thumb($goods_info,1280));
            $goods_image_mobile[] = goods_thumb($goods_info, 480);
        }

        //抢购
        if (!empty($goods_info['groupbuy_info'])) {
            $goods_info['promotion_type'] = 'groupbuy';
            $goods_info['title'] = '抢购';
            $goods_info['remark'] = $goods_info['groupbuy_info']['groupbuy_remark'];
            $goods_info['promotion_price'] = $goods_info['groupbuy_info']['groupbuy_price'];
            $goods_info['down_price'] = ds_price_format($goods_info['goods_price'] - $goods_info['groupbuy_info']['groupbuy_price']);
            $goods_info['upper_limit'] = $goods_info['groupbuy_info']['groupbuy_upper_limit'];
            unset($goods_info['groupbuy_info']);
        }

        //限时折扣
        if (!empty($goods_info['xianshi_info'])) {
            $goods_info['promotion_type'] = 'xianshi';
            $goods_info['title'] = $goods_info['xianshi_info']['xianshi_title'];
            $goods_info['remark'] = $goods_info['xianshi_info']['xianshi_title'];
            $goods_info['promotion_price'] = $goods_info['xianshi_info']['xianshigoods_price'];
            $goods_info['down_price'] = ds_price_format($goods_info['goods_price'] - $goods_info['xianshi_info']['xianshigoods_price']);
            $goods_info['lower_limit'] = $goods_info['xianshi_info']['xianshigoods_lower_limit'];
            $goods_info['explain'] = $goods_info['xianshi_info']['xianshi_explain'];
            unset($goods_info['xianshi_info']);
        }
        //拼团
        if (!empty($goods_info['pintuan_info'])) {
            $goods_info['pintuan_type'] = 'pintuan';
            $goods_info['pintuan_id'] = $goods_info['pintuan_info']['pintuan_id'];
            $goods_info['pintuan_title'] = $goods_info['pintuan_info']['pintuan_name'];
            $goods_info['pintuan_price'] = round($goods_info['pintuan_info']['pintuan_zhe'] * $goods_info['goods_price'] / 10, 2);
            $goods_info['pintuan_limit_number'] = $goods_info['pintuan_info']['pintuan_limit_number'];
            $goods_info['pintuan_limit_hour'] = $goods_info['pintuan_info']['pintuan_limit_hour'];
            $goods_info['pintuan_limit_quantity'] = $goods_info['pintuan_info']['pintuan_limit_quantity'];
            //拼团开团信息
            $goods_info['pintuangroup_list'] = $goods_info['pintuan_info']['pintuangroup_list'];
            $goods_info['pintuangroup_count'] = count($goods_info['pintuangroup_list']);
            unset($goods_info['pintuan_info']);
        }
        
        //会员等级折扣
        if (!empty($goods_info['mgdiscount_info'])) {
            $goods_info['mgdiscount_type'] = 'mgdiscount';
            $goods_info['goods_mgdiscount_arr'] = $goods_info['mgdiscount_info'];
            unset($goods_info['mgdiscount_info']);
        }
        
        // 验证是否允许送赠品
        $gift_array=array();
        if ($this->checkGoodsIfAllowGift($goods_info)) {
            $gift_array = model('goodsgift')->getGoodsgiftListByGoodsId($goods_id);
            if (!empty($gift_array)) {
                $goods_info['is_have_gift'] = 'gift';
            }
        }

        // 加入购物车按钮
        $goods_info['cart'] = true;
        //虚拟、F码、预售不显示加入购物车
        if ($goods_info['is_virtual'] == 1 || $goods_info['is_goodsfcode'] == 1 || $goods_info['is_presell'] == 1) {
            $goods_info['cart'] = false;
        }

        // 立即购买文字显示
        $goods_info['buynow_text'] = '立即购买';
        if ($goods_info['is_presell'] == 1) {
            $goods_info['buynow_text'] = '预售购买';
        } elseif ($goods_info['is_goodsfcode'] == 1) {
            $goods_info['buynow_text'] = 'F码购买';
        }
        $mansong_info=model('pmansong')->getMansongInfoByStoreID($goods_info['store_id']);
        if(empty($mansong_info)){
            $mansong_info=array();
        }
        //满即送
        $mansong_info = ($goods_info['is_virtual'] == 1) ? array() : $mansong_info;

        // 商品受关注次数加1
        $goods_info['goods_click'] = intval($goods_info['goods_click']) + 1;
        if (config('cache_open')) {
            wcache('updateRedisDate', array($goods_id => $goods_info['goods_click']), 'goodsClick');
        } else {
            $this->editGoodsById(array('goods_click' => Db::raw('goods_click+1')), $goods_id);
        }
        $result = array();
        $result['goods_info'] = $goods_info;
        $result['spec_list'] = $spec_list;
        $result['spec_list_mobile'] = $spec_list_mobile;
        $result['spec_image'] = $spec_image;
        $result['goods_image'] = $goods_image;
        $result['goods_image_mobile'] = $goods_image_mobile;
        $result['mansong_info'] = $mansong_info;
        $result['gift_array'] = $gift_array;
        return $result;
    }
    /**
     * 获取移动端商品
     * @access public
     * @author csdeshang
     * @param type $goods_commonid 商品ID
     * @return array
     */
    public function getMobileBodyByCommonID($goods_commonid) {
        $common_info = $this->_rGoodsCommonCache($goods_commonid);
        if (empty($common_info)) {
            $common_info = $this->getGoodeCommonInfo(array('goods_commonid' => $goods_commonid));
            $this->_wGoodsCommonCache($goods_commonid, $common_info);
        }


        // 手机商品描述
        if ($common_info['mobile_body'] != '') {
            $mobile_body_array = unserialize($common_info['mobile_body']);
            if (is_array($mobile_body_array)) {
                $mobile_body = '';
                foreach ($mobile_body_array as $val) {
                    switch ($val['type']) {
                        case 'text':
                            $mobile_body .='<div>' . $val['value'] . '</div>';
                            break;
                        case 'image':
                            $mobile_body .='<img src="' . $val['value'] . '">';
                            break;
                    }
                }
                $common_info['mobile_body'] = $mobile_body;
            }
        }
        return $common_info;
    }

}