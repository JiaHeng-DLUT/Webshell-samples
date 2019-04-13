<?php

namespace app\common\model;


use think\Model;

class Favorites extends Model
{
    public $page_info;

    /**
     * 收藏列表
     * @access public
     * @author csdeshang
     * @param array $condition 查询条件
     * @param string $field 查询字段
     * @param int $page 分页信息
     * @param string $order 排序
     * @return array
     */
    public function getFavoritesList($condition, $field = '*', $page = 0, $order = 'favlog_id desc')
    {
        $res= db('favorites')->where($condition)->field($field)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info=$res;
        return $res->items();
    }

    /**
     * 收藏商品列表
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @param string $field 字段
     * @param int $page 分页信息
     * @param string $order 排序
     * @return array
     */
    public function getGoodsFavoritesList($condition, $field = '*', $page = 0, $order = 'favlog_id desc')
    {
        $condition['fav_type'] = 'goods';
        return $this->getFavoritesList($condition, $field, $page, $order);
    }

    /**
     * 收藏店铺列表
     * @access public
     * @author csdeshang
     * @param array $condition 查询条件
     * @param string $field 字段
     * @param int $page 分页信息
     * @param string $order 排序
     * @return array
     */
    public function getStoreFavoritesList($condition, $field = '*', $page = 0, $order = 'favlog_id desc')
    {
        $condition['fav_type'] = 'store';
        return $this->getFavoritesList($condition, $field, $page, $order);
    }

    /**
     * 取单个收藏的内容
     * @access public
     * @author csdeshang
     * @param array $condition 查询条件
     * @return array 数组类型的返回结果
     */
    public function getOneFavorites($condition)
    {
        return db('favorites')->where($condition)->find();
    }

    /**
     * 获取店铺收藏数
     * @access public
     * @author csdeshang
     * @param int $storeId 店铺ID
     * @param int $memberId 会员ID
     * @return int
     */
    public function getStoreFavoritesCountByStoreId($storeId, $memberId = 0)
    {
        $where = array(
            'fav_type' => 'store', 'fav_id' => $storeId,
        );

        if ($memberId > 0) {
            $where['member_id'] = (int)$memberId;
        }

        return (int)db('favorites')->where($where)->count();
    }

    /**
     * 获取商品收藏数
     * @access public
     * @author csdeshang
     * @param int $goodsId 商品ID
     * @param int $memberId 会员ID
     * @return int
     */
    public function getGoodsFavoritesCountByGoodsId($goodsId, $memberId = 0)
    {
        $where = array(
            'fav_type' => 'goods', 'fav_id' => $goodsId,
        );

        if ($memberId > 0) {
            $where['member_id'] = (int)$memberId;
        }

        return (int)db('favorites')->where($where)->count();
    }

    /**
     * 新增收藏
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addFavorites($data)
    {
        if (empty($data)) {
            return false;
        }
        if ($data['fav_type'] == 'store') {
            $store_id = intval($data['fav_id']);
            $store_model = model('store');
            $store = $store_model->getStoreInfoByID($store_id);
            $data['store_name'] = $store['store_name'];
            $data['store_id'] = $store['store_id'];
            $data['storeclass_id'] = $store['storeclass_id'];
        }
        if ($data['fav_type'] == 'goods') {
            $goods_id = intval($data['fav_id']);
            $goods_model = model('goods');
            $goods = $goods_model->getGoodsInfoByID($goods_id);
            $data['goods_name'] = $goods['goods_name'];
            $data['goods_image'] = $goods['goods_image'];
            $data['favlog_price'] = $goods['goods_promotion_price'];//商品收藏时价格
            $data['favlog_msg'] = $goods['goods_promotion_price'];//收藏备注，默认为收藏时价格，可修改
            $data['gc_id'] = $goods['gc_id'];

            $store_id = intval($goods['store_id']);
            $store_model = model('store');
            $store = $store_model->getStoreInfoByID($store_id);
            $data['store_name'] = $store['store_name'];
            $data['store_id'] = $store['store_id'];
            $data['storeclass_id'] = $store['storeclass_id'];
        }
        return db('favorites')->insertGetId($data);
    }

    /**
     * 修改记录
     * @access public
     * @author csdeshang
     * @param type $condition 修改条件
     * @param type $data 修改数据
     * @return boolean
     */
    public function editFavorites($condition, $data)
    {
        if (empty($condition)) {
            return false;
        }
        if (is_array($data)) {
            $result = db('favorites')->where($condition)->update($data);
            return $result;
        }
        else {
            return false;
        }
    }

    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param array $condition 查询条件
     * @return bool 布尔类型的返回结果
     */
    public function delFavorites($condition)
    {
        if (empty($condition)) {
            return false;
        }
        return db('favorites')->where($condition)->delete();
    }

    /**
     * 获取店铺收藏数
     * @access public
     * @author csdeshang
     * @param int $id 会员ID
     * @return int
     */
    public function getStoreFavoritesCountByMemberId($id)
    {
        $where = array(
            'fav_type' => 'store',

        );

        if ($id > 0) {
            $where['member_id'] = (int)$id;
        }

        return (int)db('favorites')->where($where)->count();
    }
    /**
     * 获取商品收藏数
     * @access public
     * @author csdeshang
     * @param int $id 会员ID
     * @return int
     */
    public function getGoodsFavoritesCountByMemberId($id)
    {
        $where = array(
            'fav_type' => 'goods',

        );

        if ($id > 0) {
            $where['member_id'] = (int)$id;
        }

        return (int)db('favorites')->where($where)->count();
    }
}