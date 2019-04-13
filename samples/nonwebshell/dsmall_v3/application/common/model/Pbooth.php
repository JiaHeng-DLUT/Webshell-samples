<?php
/**
 * 推荐展位管理
 *
 */

namespace app\common\model;

use think\Model;

class Pbooth extends Model
{

    const STATE1 = 1;       // 开启
    const STATE0 = 0;       // 关闭
    public $page_info;

    /**
     * 展位套餐列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @param int $page 分页
     * @param string $order 排序
     * @return array
     */
    public function getBoothquotaList($condition, $field = '*', $page = 0, $order = 'boothquota_id desc')
    {
        $res= db('pboothquota')->field($field)->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info=$res;
        return $res->items();
    }

    /**
     * 展位套餐详细信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return array
     */
    public function getBoothquotaInfo($condition, $field = '*')
    {
        return db('pboothquota')->field($field)->where($condition)->find();
    }

    /**
     * 展位套餐详细信息
     * @access public
     * @author csdeshang
     * @param int $store_id 店铺ID
     * @param string $field 字段
     * @return array
     */
    public function getBoothquotaInfoCurrent($store_id)
    {
        $condition['store_id'] = $store_id;
        $condition['boothquota_endtime'] = array('gt', TIMESTAMP);
        $condition['boothquota_state'] = 1;
        return $this->getBoothquotaInfo($condition);
    }

    /**
     * 保存推荐展位套餐
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return boolean
     */
    public function addBoothquota($data)
    {
        return db('pboothquota')->insertGetId($data);
    }

    /**
     * 表示推荐展位套餐
     * @access public
     * @author csdeshang
     * @param array $update 更新数据
     * @param array $condition 条件
     * @return array
     */
    public function editBoothquota($update, $condition)
    {
        return db('pboothquota')->where($condition)->update($update);
    }

    /**
     * 编辑推荐展位套餐
     * @access public
     * @author csdeshang
     * @param array $update  更新数据
     * @param array $condition 条件
     * @return array
     */
    public function editBoothquotaOpen($update, $condition)
    {
        $update['boothquota_state'] = self::STATE1;
        return db('pboothquota')->where($condition)->update($update);
    }

    /**
     * 商品列表
     * @access public
     * @author csdeshang
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @param int $page 分页
     * @param int $limit 限制
     * @param string $order 排序
     * @return array
     */
    public function getBoothgoodsList($condition, $field = '*', $page = 0, $limit = 0, $order = 'boothgoods_id asc') {
        $condition = $this->_getRecursiveClass($condition);
        if ($page) {
            $res = db('pboothgoods')->field($field)->where($condition)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('pboothgoods')->field($field)->where($condition)->limit($limit)->order($order)->select();
        }
    }

    /**
     * 保存套餐商品信息
     * @access public
     * @author csdeshang
     * @param array $data 数据
     * @return boolean
     */
    public function addBoothgoods($data)
    {
        return db('pboothgoods')->insertGetId($data);
    }

    /**
     * 编辑套餐商品信息
     * @access public
     * @author csdeshang
     * @param array $update 更新数据
     * @param array $condition 更新条件
     */
    public function editBooth($update, $condition)
    {
        return db('pboothgoods')->where($condition)->update($update);
    }

    /**
     * 更新套餐为关闭状态
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function editBoothClose($condition)
    {
        $quota_list = $this->getBoothquotaList($condition);
        if (empty($quota_list)) {
            return true;
        }
        $storeid_array = array();
        foreach ($quota_list as $val) {
            $storeid_array[] = $val['store_id'];
        }
        $where = array('store_id' => array('in', $storeid_array));
        $update = array('boothquota_state' => self::STATE0);
        $this->editBoothquota($update, $where);
        
        $update = array('boothgoods_state' => self::STATE0);
        $this->editBooth($update, $where);
        return true;
    }

    /**
     * 删除套餐商品
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function delBoothgoods($condition)
    {
        return db('pboothgoods')->where($condition)->delete();
    }

    /**
     * 获得商品子分类的ID
     * @access public
     * @author csdeshang
     * @param array $condition 查询条件
     * @return array
     */
    private function _getRecursiveClass($condition)
    {
        if (isset($condition['gc_id']) && !is_array($condition['gc_id'])) {
            $gc_list = model('goodsclass')->getGoodsclassForCacheModel();
            if (isset($gc_list[$condition['gc_id']])) {
                $gc_id[] = $condition['gc_id'];
                $gcchild_id = empty($gc_list[$condition['gc_id']]['child']) ? array() : explode(',', $gc_list[$condition['gc_id']]['child']);
                $gcchildchild_id = empty($gc_list[$condition['gc_id']]['childchild']) ? array() : explode(',', $gc_list[$condition['gc_id']]['childchild']);
                $gc_id = array_merge($gc_id, $gcchild_id, $gcchildchild_id);
                $condition['gc_id'] = array('in', $gc_id);
            }
        }
        return $condition;
    }
}
