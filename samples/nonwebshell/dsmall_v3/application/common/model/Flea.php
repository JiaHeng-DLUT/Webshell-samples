<?php
namespace app\common\model;

use think\Model;
use think\Db;
class Flea extends Model
{
    public $page_info;

    /**
     * 商品保存
     * @access public
     * @author csdeshang
     * @param array $data 商品资料
     * @return boolean
     */
    public function addFlea($data)
    {
        if (empty($data)) {
            return false;
        }
        $goods_array = array();
        $goods_array['goods_name'] = $data['goods_name'];
        $goods_array['fleaclass_id'] = $data['fleaclass_id'];
        $goods_array['fleaclass_name'] = $data['fleaclass_name'];
        $goods_array['member_id'] = $data['member_id'];
        $goods_array['member_name'] = $data['member_name'];
        //$goods_array['goods_image'] = $data['goods_image'];
        $goods_array['flea_quality'] = $data['flea_quality'];
        $goods_array['fleaarea_id'] = $data['fleaarea_id'];
        $goods_array['fleaarea_name'] = $data['fleaarea_name'];
        $goods_array['flea_pname'] = $data['flea_pname'];
        $goods_array['flea_pphone'] = $data['flea_pphone'];
        $goods_array['goods_tag'] = $data['goods_tag'];
        $goods_array['goods_price'] = $data['goods_price'];
        $goods_array['goods_store_price'] = $data['goods_store_price'];
        $goods_array['goods_show'] = $data['goods_show'];
        //$goods_array['goods_commend'] = $data['goods_commend'];
        $goods_array['goods_addtime'] = TIMESTAMP;
        $goods_array['goods_body'] = $data['goods_body'];
        $goods_array['goods_keywords'] = $data['goods_keywords'];
        $goods_array['goods_description'] = $data['goods_description'];

        $result = db('flea')->insertGetId($goods_array);
        return $result;
    }
    
    /**
     * 获取单个闲置
     * @access public
     * @author csdeshang
     * @param type $condition 查询条件
     * @return type
     */
    public function getOneFlea($condition){
        return db('flea')->where($condition)->find();
    }

    /**
     * 商品列表
     * @access public
     * @author csdeshang
     * @param type $condition 查询条件
     * @param type $page 分页信息
     * @param type $field 字段
     * @return type
     */
    public function getFleaList($condition, $page = '', $field = '*',$order = 'goods_id desc')
    {
        $where = $this->getCondition($condition);
        if ($page) {
            $res = db('flea')->alias('flea')->where($where)->field($field)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            $list_goods = $res->items();
        }else{
            $limit = '';
            if(isset($condition['limit'])){
                $limit = $condition['limit'];
            }
            $list_goods = db('flea')->alias('flea')->where($where)->field($field)->order($order)->limit($limit)->select();
        }
        return $list_goods;
    }

    /**
     * 他们正在卖的
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $limit 分页信息
     * @param type $field 字段
     * @return type
     */
    
    public function getSaleFleaList($condition, $limit = '10', $field = 'member.member_id,member.member_name,flea.*')
    {
        $order = 'goods_id desc';
        $list_goods = db('flea')->alias('flea')->join('__MEMBER__ member', 'flea.member_id=member.member_id', 'LEFT')->field($field)->order($order)->where($condition)->limit($limit)->select();
        return $list_goods;
    }

    /**
     * 他们正在统计当前卖家正在出售闲置个数卖的
     * @access public
     * @author csdeshang
     * @param type $member_id 会员id
     * @return type
     */
    public function getFleaStatistic($member_id)
    {
        $field = 'member.member_avatar,member.member_qq,member.member_id,member.member_name,count(*) as num';
        $group = 'member.member_id';
        $goods_array = db('flea')->alias('flea')->join('__MEMBER__ member', 'flea.member_id=member.member_id', 'LEFT')->field($field)->where('member.member_id',$member_id)->group($group)->select();
        return $goods_array['0'];
    }

    /**
     * 闲置物品多图
     * @access public
     * @author csdeshang
     * @param  array $condition 列表条件
     * @param  array $page 分页页数
     * @return type
     */
    public function getFleauploadList($condition,$page='')
    {
        if($page){
            $member_list = db('fleaupload')->where($condition)->paginate($page,false,['query' => request()->param()]);
            $this->page_info = $member_list;
            $result= $member_list->items();
        }else{
            $result = db('fleaupload')->where($condition)->select();
        }
        return $result;
    }

    /**
     * 得到商品所有缩略图，带商品路径
     * @access public
     * @author csdeshang
     * @param type $goods 商品列表
     * @param type $path  商品路径 
     * @return type
     */
    public function getThumb(&$goods, $path)
    {
        if (is_array($goods)) {
            foreach ($goods as $k => $v) {
                $goods[$k]['thumb_small'] = $path . $v['fleafile_name'];
                $goods[$k]['thumb_big'] = $path . str_replace('_small', '_big', $v['fleafile_name']);
            }
        }
    }

    /**
     * 商品信息更新
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @param type $goods_id 商品id
     * @return boolean
     */
    public function editFlea($data, $goods_id) {
        if (empty($data)) {
            return false;
        }
        $update = db('flea')->where('goods_id', $goods_id)->update($data);
        return $update;
    }

    /**
     * 闲置物品数量
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return int
     */
    public function getFleaCount($condition)
    {
        if (empty($condition)) {
            return false;
        }
        $count = db('flea')->where($condition)->count();
        return $count;
    }

    /**
     * 闲置物品删除
     * @access public
     * @author csdeshang
     * @param type $goods_id 商品id
     * @return boolean
     */
    public function delFlea($goods_id)
    {
        if (empty($goods_id)) {
            return false;
        }
        if(is_array($goods_id)){
            $del_state = db('flea')->where('goods_id','in', $goods_id)->delete();
        }else{
            $del_state = db('flea')->where('goods_id', $goods_id)->delete();
        }
        
        if ($del_state) {
            $image_more = db('fleaupload')->field('fleafile_name')->whereIn('item_id', $goods_id)->whereIn('fleaupload_type', '12,13')->select();
            if (is_array($image_more) && !empty($image_more)) {
                foreach ($image_more as $v) {
                    @unlink(BASE_UPLOAD_PATH . DS . ATTACH_MFLEA . DS . $v['store_id'] . DS . $v['fleafile_name']);
                }
            }
            db('fleaupload')->whereIn('item_id', $goods_id)->whereIn('fleaupload_type', '12,13')->select();
        }
        return true;
    }

    
    /**
     * 按所属分类查找闲置物品
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getFleaByClass($condition,$field='*',$order='',$limit=10)
    {
        $goods_array = db('flea')->alias('flea')->join('__FLEACLASS__ fleaclass','flea.fleaclass_id=fleaclass.fleaclass_id')->where($condition)->field($field)->order($order)->limit($limit)->select();
        return $goods_array;
    }

    /**
     * 将条件数组组合为SQL语句的条件部分
     * @access public
     * @author csdeshang
     * @param type $condition_array 条件数组
     * @return string
     */
    private function getCondition($condition_array)
    {
        $condition_sql = '1=1';
        if (isset($condition_array['member_id']) && $condition_array['member_id'] != '') {
            $condition_sql .= " and member_id = " . $condition_array['member_id'];
        }
        if (isset($condition_array['image_store_id']) && $condition_array['image_store_id'] != '') {
            $condition_sql .= " and store_id=" . $condition_array['image_store_id'] . " and item_id=" . $condition_array['item_id'] . " and fleaupload_type='" . $condition_array['image_type'] . "'";
        }
        //添加不等于某商品的条件
        if (isset($condition_array['goods_id_diff']) && $condition_array['goods_id_diff'] != 0) {
            $condition_sql .= " and goods_id<>" . $condition_array['goods_id_diff'];
        }
        if (isset($condition_array['fleaclass_id_list']) && $condition_array['fleaclass_id_list'] != '') {
            $condition_sql .= " and `flea`.fleaclass_id IN (" . ltrim($condition_array['fleaclass_id_list'], ',') . ")";
        }
        if (isset($condition_array['goods_id']) && $condition_array['goods_id'] != 0) {
            $condition_sql .= " and goods_id = " . $condition_array['goods_id'];
        }
        if (isset($condition_array['keyword']) && $condition_array['keyword'] != '') {
            $condition_sql .= " and goods_name LIKE '%" . $condition_array['keyword'] . "%'";
        }
        if (isset($condition_array['upload_id']) && $condition_array['upload_id'] != '') {
            $condition_sql .= " and fleaupload_id=" . $condition_array['upload_id'];
        }
        if (isset($condition_array['goods_id_in'])) {
            if ($condition_array['goods_id_in'] == '') {
                $condition_sql .= " and `flea`.goods_id in ('') ";
            }
            else {
                $condition_sql .= " and `flea`.goods_id in({$condition_array['goods_id_in']})";
            }
        }
        if (isset($condition_array['fleaclass_id']) && $condition_array['fleaclass_id'] != '') {
            $condition_sql .= " and fleaclass_id IN (" . $this->_getRecursiveClass(array($condition_array['fleaclass_id'])) . ")";
            //$condition_sql	.= " and `goods`.fleaclass_id IN ({$condition_array['fleaclass_id']})";
        }
        if (isset($condition_array['fleaclass_id_in'])) {
            if ($condition_array['fleaclass_id_in'] == '') {
                $condition_sql .= " and `flea`.fleaclass_id in ('') ";
            }
            else {
                $condition_sql .= " and `flea`.fleaclass_id in({$condition_array['fleaclass_id_in']})";
            }
        }
        if (isset($condition_array['key_input']) && $condition_array['key_input'] != '') {
            $condition_sql .= " and (goods_name LIKE '%{$condition_array['key_input']}%' or goods_tag like '%{$condition_array['key_input']}%')";
        }
        if (isset($condition_array['like_member_name']) && $condition_array['like_member_name'] != '') {
            $condition_sql .= " and member_name LIKE '%" . $condition_array['like_member_name'] . "%'";
        }
        /*	检索	*/
        if (isset($condition_array['pic_input']) && $condition_array['pic_input'] == 2) {
            $condition_sql .= " and goods_image <> ''";
        }
        if (isset($condition_array['body_input']) && $condition_array['body_input'] == 2) {
            $condition_sql .= " and goods_body <> ''";
        }
        if (isset($condition_array['seller_input']) && $condition_array['seller_input'] != '') {
            $condition_sql .= " and member_id = " . $condition_array['seller_input'];
        }
        if (isset($condition_array['quality_input']) && $condition_array['quality_input'] != '') {
            if ($condition_array['quality_input'] == 7) {
                $condition_sql .= " and flea_quality <= 7";
            }
            else {
                $condition_sql .= " and flea_quality >= " . $condition_array['quality_input'];
            }
        }
        if (isset($condition_array['start_input']) && $condition_array['start_input'] != '') {
            $condition_sql .= " and goods_store_price >= " . $condition_array['start_input'];
        }
        if (isset($condition_array['end_input']) && $condition_array['end_input'] != '') {
            $condition_sql .= " and goods_store_price <= " . $condition_array['end_input'];
        }
        if (isset($condition_array['areaid']) && $condition_array['areaid'] != '') {
            $condition_sql .= " and fleaarea_id in (" . $condition_array['areaid'] . ")";
        }
        return $condition_sql;
    }
    /**
     * 递归得到商品分类的ID
     * @access public
     * @author csdeshang
     * @staticvar string $class_list
     * @param type $class_id 分类ID
     * @return type
     */
    private function _getRecursiveClass($class_id)
    {

        static $class_list = '';

        $id = implode(',', $class_id);
        $class_list .= ',' . $id;

        $temp_list = db('fleaclass')->where('fleaclass_parent_id','in',$id)->field('fleaclass_id')->select();
        if (!empty($temp_list)) {

            $_tmp = array();    //取得ID组成的一维数组

            foreach ($temp_list as $key => $val) {

                $_tmp[] = $val['fleaclass_id'];

            }
            unset($temp_list);
            $temp_list = $_tmp;
            $id = $this->_getRecursiveClass($temp_list);

        }
        return trim($class_list, ',');

    }
}