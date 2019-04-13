<?php

namespace app\common\model;


use think\Model;

class Activitydetail extends Model
{
    public $page_info;
    /**
     * 添加
     * @author csdeshang
     * @param array $data
     * @return bool
     */
    public function addActivitydetail($data){
        return db('activitydetail')->insertGetId($data);
    }

    /**
     * 根据条件更新
     * @author csdeshang
     * @param array $data 更新内容
     * @param array $condition 更新条件
     * @return bool
     */
    public function editActivitydetail($data,$condition){
        return db('activitydetail')->where($condition)->update($data);
    }

    /**
     * 根据条件删除
     * @author csdeshang
     * @param array $condition 条件数组
     * @return bool
     */
    public function delActivitydetail($condition){
        return db('activitydetail')->where($condition)->delete();
    }
    /**
     * 根据条件查询活动内容信息
     * @author csdeshang
     * @param array $condition 查询条件数组
     * @param obj $page	分页页数
     * @param string $order 排序
     * @return array 二维数组
     */
    public function getActivitydetailList($condition,$page='',$order='activitydetail_sort desc'){
        if ($page) {
            $res = db('activitydetail')->where($condition)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        }else{
            return db('activitydetail')->where($condition)->order($order)->select();
        }
    }
    /**
     * 根据条件查询活动商品内容信息
     * @author csdeshang
     * @param array $condition 查询条件数组
     * @param obj $page	分页页数
     * @param string $order 排序
     * @return array 二维数组
     */
    public function getGoodsJoinList($condition,$page='',$order=''){
        $field	= 'activitydetail.*,goods.*';
        $res=db('activitydetail')->alias('activitydetail')->join('__GOODS__ goods','activitydetail.item_id=goods.goods_id')->field($field)->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info=$res;
        return $res->items();
    }
    /**
     * 查询活动商品信息
     * @author csdeshang
     * @param array $condition 查询条件数组
     * @return array 二维数组
     */
    public function getActivitydetailAndGoodsList($condition){
        $field	= 'activitydetail.activitydetail_sort,goods.goods_id,goods.store_id,goods.goods_name,goods.goods_price,goods.goods_image';
        $res= db('activitydetail')->alias('activitydetail')->join('__GOODS__ goods','activitydetail.item_id=goods.goods_id')->field($field)->where($condition)->select();
        return $res;
    }
}