<?php

namespace app\common\model;

use think\Model;

class Stat extends Model
{

    public $page_info;

    /**
     * 查询新增会员统计
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return array
     */
    public function statByMember($where, $field = '*', $page = 0, $order = '', $group = '')
    {
        if ($page) {
        $res = db('member')->field($field)->where($where)->group($group)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info = $res;
        return $res->items();
        } else {
            return db('member')->field($field)->where($where)->page($page)->order($order)->group($group)->select();
        }
        
    }

    /**
     * 查询单条会员统计
     * @access public
     * @author csdeshang
     * @param array $where 条件
     * @param string $field 字段
     * @param string $order 排序
     * @param string $group 分组
     * @return array
     */
    public function getOneByMember($where, $field = '*', $order = '', $group = '')
    {
        return db('member')->field($field)->where($where)->order($order)->group($group)->find();
    }

    /**
     * 查询单条店铺统计
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $field 字段
     * @param type $order 排序
     * @param type $group 分组
     * @return type
     */
    public function getOneByStore($where, $field = '*', $order = '', $group = '')
    {
        return db('store')->field($field)->where($where)->order($order)->group($group)->find();
    }

    /**
     * 查询店铺统计
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $field 字段
     * @param type $order 排序
     * @param type $group 分组
     * @return type
     */
    public function statByStore($where, $field = '*', $order = '', $group = '')
    {
        return db('store')->field($field)->where($where)->group($group)->order($order)->select();
    }

    /**
     * 查询新增店铺统计
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @param int $page 分页
     * @param string $order 排序
     * @param int $limit 限制
     * @param sting $group 分组
     * @return array
     */
    public function getNewStoreStatList($condition, $field = '*', $page = 0, $order = 'store_id desc', $limit = 0, $group = '') {
        if ($page) {
            $res = db('store')->field($field)->where($condition)->group($group)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('store')->field($field)->where($condition)->group($group)->order($order)->limit($limit)->select();
        }
    }

    /**
     * 查询会员列表
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $field 字段
     * @param type $page 分页
     * @param type $order 排序
     * @return type
     */
    public function getMemberList($where, $field = '*', $page = 0, $order = 'member_id desc')
    {
        $res = db('member')->field($field)->where($where)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info = $res;
        return $res->items();
    }

    /**
     * 调取店铺等级信息
     * @access public
     * @author csdeshang
     * @return type
     */
    public function getStoreDegree()
    {
        $tmp = db('storegrade')->field('storegrade_id,storegrade_name')->where(true)->select();
        $sd_list = array();
        if (!empty($tmp)) {
            foreach ($tmp as $k => $v) {
                $sd_list[$v['storegrade_id']] = $v['storegrade_name'];
            }
        }
        return $sd_list;
    }

  
    /**
     * 查询会员统计数据记录
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $field 字段
     * @param type $page 分页
     * @param type $limit 限制
     * @param type $order 排序
     * @param type $group 分组
     * @return array
     */
    public function statByStatmember($where, $field = '*', $page = 0, $limit = 0, $order = '', $group = '')
    {
        $res = db('statmember')->field($field)->where($where)->limit($limit)->order($order)->group($group)->paginate($page,false,['query' => request()->param()]);
        $this->page_info = $res;
        return $res->items();
    }

    /**
     * 查询商品数量
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @return type
     */
    public function getGoodsNum($where)
    {
        $rs = db('goodscommon')->field('count(*) as allnum')->where($where)->select();
        return $rs[0]['allnum'];
    }

    /**
     * 获取预存款数据
     * @access public
     * @author csdeshang 
     * @param type $condition 条件
     * @param type $field 字段
     * @param type $page  分页
     * @param type $order 排序
     * @param type $limit 限制
     * @param type $group 分组
     * @return type
     */
    public function getPredepositInfo($condition, $field = '*', $page = 0, $order = 'lg_addtime desc', $limit = 0, $group = '')
    {
        if ($page) {
        $res = db('pdlog')->field($field)->where($condition)->group($group)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info = $res;
        return $res->items();
        } else {
            return db('pdlog')->field($field)->where($condition)->group($group)->order($order)->limit($limit)->select();
        }
    }

    /**
     * 获取结算数据
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $type 类型
     * @param type $have_page 判断分页
     * @return type
     */
    public function getBillList($condition, $type, $have_page = true)
    {
        switch ($type) {
            case 'os'://平台
                return db('orderstatis')->field('sum(os_order_totals) as oot,sum(os_order_returntotals) as oort,sum(os_commis_totals-os_commis_returntotals) as oct,sum(os_store_costtotals) as osct,sum(os_result_totals) as ort')->where($condition)->select();
                break;
            case 'ob'://店铺
                $page = $have_page ? 15 : '';
                $result = db('orderbill')->alias('order_bill')->join('__STORE__ store', 'order_bill.ob_store_id=store.store_id', 'left')->field('order_bill.*,store.member_name')->where($condition)->order('ob_no desc')->paginate($page,false,['query' => request()->param()]);
                $this->page_info = $result;
                return $result->items();
                break;
        }
    }

    /**
     * 查询订单及订单商品的统计
     * @access public
     * @author csdeshang 
     * @param type $where 条件
     * @param type $field 字段
     * @param type $page 分页
     * @param type $limit 限制
     * @param type $order 排序
     * @param type $group 分组
     * @return type
     */
    public function statByOrderGoods($where, $field = '*', $page = 0, $limit = 0, $order = '', $group = '')
    {
        $res = db('ordergoods')->alias('ordergoods')->field($field)->join('__ORDER__ order', 'ordergoods.order_id=order.order_id', 'left')->where($where)->group($group)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info = $res;
        return $res->items();
    }

    /**
     * 查询订单及订单商品的统计
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $field 字段
     * @param type $page  分页
     * @param type $limit 限制
     * @param type $order 排序
     * @param type $group 分组
     * @return type
     */
    public function statByOrderLog($where, $field = '*', $page = 0, $limit = 0, $order = '', $group = '')
    {
        $res = db('orderlog')->alias('orderlog')->field($field)->join('__ORDER__ order', 'orderlog.order_id = order.order_id', 'left')->where($where)->group($group)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info = $res;
        return $res->items();
    }

    /**
     * 查询退款退货统计
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $field 字段
     * @param type $page  分页
     * @param type $limit 限制
     * @param type $order 排序
     * @param type $group 分组
     * @return type
     */
    public function statByRefundreturn($where, $field = '*', $page = 0, $limit = 0, $order = '', $group = '')
    {
        if ($page) {
        $res = db('refundreturn')->field($field)->where($where)->group($group)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info = $res;
        return $res->items();
        } else {
            return db('refundreturn')->field($field)->where($where)->group($group)->order($order)->limit($limit)->select();
        }
    }

    /**
     * 查询店铺动态评分统计
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $field 字段
     * @param type $page  分页
     * @param type $limit 限制
     * @param type $order 排序
     * @param type $group 分组
     * @return type
     */
    public function statByStoreAndEvaluatestore($where, $field = '*', $page = 0, $limit = 0, $order = '', $group = '')
    {
        $res = db('evaluatestore')->alias('evaluatestore')->field($field)->join('__STORE__ store', 'evaluatestore.seval_storeid=store.store_id', 'left')->where($where)->group($group)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info = $res;
        return $res->items();
    }

    /**
     * 处理搜索时间
     * @access public
     * @author csdeshang
     * @param type $search_arr 搜索数组
     * @return type
     */
    public function dealwithSearchTime($search_arr)
    {
        //初始化时间
        //天
        if (!isset($search_arr['search_time'])) {
            $search_arr['search_time'] = date('Y-m-d', time() - 86400);
        }
        $search_arr['day']['search_time'] = strtotime($search_arr['search_time']); //搜索的时间
        //周
        if (!isset($search_arr['searchweek_year'])) {
            $search_arr['searchweek_year'] = date('Y', time());
        }
        if (!isset($search_arr['searchweek_month'])) {
            $search_arr['searchweek_month'] = date('m', time());
        }
        if (!isset($search_arr['searchweek_week'])) {
            $search_arr['searchweek_week'] = implode('|', getWeek_SdateAndEdate(time()));
        }
        $weekcurrent_year = $search_arr['searchweek_year'];
        $weekcurrent_month = $search_arr['searchweek_month'];
        $weekcurrent_week = $search_arr['searchweek_week'];
        $search_arr['week']['current_year'] = $weekcurrent_year;
        $search_arr['week']['current_month'] = $weekcurrent_month;
        $search_arr['week']['current_week'] = $weekcurrent_week;

        //月
        if (!isset($search_arr['searchmonth_year'])) {
            $search_arr['searchmonth_year'] = date('Y', time());
        }
        if (!isset($search_arr['searchmonth_month'])) {
            $search_arr['searchmonth_month'] = date('m', time());
        }
        $monthcurrent_year = $search_arr['searchmonth_year'];
        $monthcurrent_month = $search_arr['searchmonth_month'];
        $search_arr['month']['current_year'] = $monthcurrent_year;
        $search_arr['month']['current_month'] = $monthcurrent_month;
        return $search_arr;
    }

    /**
     * 获得查询的开始和结束时间
     * @access public
     * @author csdeshang
     * @param type $search_arr 搜索数组
     * @return type
     */
    public function getStarttimeAndEndtime($search_arr)
    {
        $stime=array();
        $etime=array();
        if (isset($search_arr['search_type'])&&$search_arr['search_type'] == 'day') {
            $stime = $search_arr['day']['search_time']; //今天0点
            $etime = $search_arr['day']['search_time'] + 86400 - 1; //今天24点
        }
        if (isset($search_arr['search_type'])&&$search_arr['search_type'] == 'week') {
            $current_weekarr = explode('|', $search_arr['week']['current_week']);
            $stime = strtotime($current_weekarr[0]);
            $etime = strtotime($current_weekarr[1]) + 86400 - 1;
        }
        if (isset($search_arr['search_type'])&&$search_arr['search_type'] == 'month') {
            $stime = strtotime($search_arr['month']['current_year'] . '-' . $search_arr['month']['current_month'] . "-01 0 month");
            $etime = getMonthLastDay($search_arr['month']['current_year'], $search_arr['month']['current_month']) + 86400 - 1;
        }
        return array($stime, $etime);
    }

    /**
     * 查询会员统计数据单条记录
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $field 字段
     * @param type $order 排序
     * @param type $group 分组
     * @return type
     */
    public function getOneStatmember($where, $field = '*', $order = '', $group = '')
    {
        return db('statmember')->field($field)->where($where)->group($group)->order($order)->find();
    }

    /**
     * 更新会员统计数据单条记录
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $update_arr 更新数据
     * @return type
     */
    public function editStatmember($where, $update_arr)
    {
        return db('statmember')->where($where)->update($update_arr);
    }

    /**
     * 查询订单的统计
     * @access public
     * @author csdeshang
     * @param array $where 条件
     * @param string $field 字段
     * @param int $page 分页
     * @param int $limit 限制
     * @param string $order 排序
     * @return array
     */
    public function statByOrder($where, $field = '*', $page = 0, $limit = 0, $order = '')
    {
        $res = db('order')->field($field)->where($where)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info = $res;
        return $res->items();
    }

    /**
     * 查询积分的统计
     * @access public
     * @author csdeshang
     * @param array $where 条件
     * @param string $field 字段
     * @param int $page 分页
     * @param int $limit 限制
     * @param string $order 排序
     * @param string $group 分组
     */
    public function statByPointslog($where, $field = '*', $page = 0, $limit = 0, $order = '', $group = '')
    {

        $res = db('pointslog')->field($field)->where($where)->group($group)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info = $res;
        return $res->items();
    }

    /**
     * 删除会员统计数据记录
     * @access public
     * @author csdeshang
     * @param type $where 条件数组
     */
    public function delByStatmember($where = array())
    {
        db('statmember')->where($where)->delete();
    }

    /**
     * 查询订单商品缓存的统计
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $field 字段
     * @param type $order 排序
     * @param type $group 分组
     * @return type
     */
    public function getoneByStatordergoods($where, $field = '*', $order = '', $group = '')
    {
        return db('statordergoods')->field($field)->where($where)->group($group)->order($order)->find();
    }

    /**
     * 查询订单商品缓存的统计
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $field 字段
     * @param type $page 分页
     * @param type $limit 限制
     * @param type $order 排序
     * @param type $group 分组
     * @return type
     */
    public function statByStatordergoods($where, $field = '*', $page = 0, $limit = 0, $order = '', $group = '')
    {
        
        if ($page) {
        $res = db('statordergoods')->field($field)->where($where)->group($group)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info = $res;
        return $res->items();
        } else {
            return db('statordergoods')->field($field)->where($where)->group($group)->order($order)->limit($limit)->select();
        }
    }

    /**
     * 查询订单缓存的统计
     * @access public
     * @author csdeshang
     * @param array $where 条件
     * @param string $field 字段
     * @param string $order 排序
     * @param string $group 分组
     * @return array
     */
    public function getoneByStatorder($where, $field = '*', $order = '', $group = '')
    {
        return db('statorder')->field($field)->where($where)->group($group)->order($order)->find();
    }

    /**
     * 查询订单缓存的统计
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $field 字段
     * @param type $page  分页
     * @param type $limit 限制
     * @param type $order 排序
     * @param type $group 分组
     * @return type
     */
    public function statByStatorder($where, $field = '*', $page = 0, $limit = 0, $order = '', $group = '') {
        if ($page) {
            $res = db('statorder')->field($field)->where($where)->group($group)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('statorder')->field($field)->where($where)->group($group)->order($order)->limit($limit)->select();
        }
    }

    /**
     * 查询商品列表
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $field 字段
     * @param type $page 分页
     * @param type $limit 限制
     * @param type $order 排序
     * @param type $group 分组
     * @return type
     */
    public function statByGoods($where, $field = '*', $page = 0, $limit = 0, $order = '', $group = '')
    {

        $res = db('goods')->field($field)->where($where)->group($group)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info = $res;
        return $res->items();
    }

    /**
     * 查询流量统计单条记录
     * @access public
     * @author csdeshang
     * @param type $tablename 表名
     * @param type $where 条件
     * @param type $field 字段
     * @param type $order 排序
     * @param type $group 分组
     * @return type
     */
    public function getoneByFlowstat($tablename = 'flowstat', $where, $field = '*', $order = '', $group = '')
    {
        return db($tablename)->field($field)->where($where)->group($group)->order($order)->find();
    }

    /**
     * 查询流量统计记录
     * @access public
     * @author csdeshang
     * @param string $tablename 表名
     * @param array $where 条件
     * @param string $field 字段
     * @param int $page 分页
     * @param int $limit 限制
     * @param string $order 排序
     * @param string $group 分组
     * @return array
     */
    public function statByFlowstat($tablename = 'flowstat', $where, $field = '*', $page = 0, $limit = 0, $order = '', $group = '')
    {
		if ($page) {
			$res = db($tablename)->field($field)->where($where)->group($group)->order($order)->paginate($page,false,['query' => request()->param()]);
			$this->page_info = $res;
			return $res->items();
        } else {
            return db($tablename)->field($field)->where($where)->group($group)->order($order)->limit($limit)->select();
        }
    }

}
