<?php

namespace app\common\model;
use think\Model;
use think\Db;
class Exppoints extends Model {

    public $page_info;
    /**
     * 操作经验值
     * @access public
     * @author csdeshang
     * @param  string $stage 操作阶段 login(登录),comments(评论),order(下单)
     * @param  array $insertarr 该数组可能包含信息 array('explog_memberid'=>'会员编号','explog_membername'=>'会员名称','explog_points'=>'经验值','explog_desc'=>'描述','orderprice'=>'订单金额','order_sn'=>'订单编号','order_id'=>'订单序号');
     * @return bool
     */
    function saveExppointslog($stage, $insertarr) {
        if (!$insertarr['explog_memberid']) {
            return false;
        }
        $exppoints_rule = config("exppoints_rule") ? unserialize(config("exppoints_rule")) : array();
        if(empty($exppoints_rule['exp_login'])){
            return;
        }
        //记录原因文字
        switch ($stage) {
            case 'login':
                if (!isset($insertarr['explog_desc'])) {
                    $insertarr['explog_desc'] = '会员登录';
                }
                $insertarr['explog_points'] = 0;
                if (intval($exppoints_rule['exp_login']) > 0) {
                    $insertarr['explog_points'] = intval($exppoints_rule['exp_login']);
                }
                break;
            case 'comments':
                if (!isset($insertarr['explog_desc'])) {
                    $insertarr['explog_desc'] = '评论商品';
                }
                $insertarr['explog_points'] = 0;
                if (intval($exppoints_rule['exp_comments']) > 0) {
                    $insertarr['explog_points'] = intval($exppoints_rule['exp_comments']);
                }
                break;
            case 'system':
                break;
            case 'order':
                if (!isset($insertarr['explog_desc'])) {
                    $insertarr['explog_desc'] = '订单' . $insertarr['order_sn'] . '购物消费';
                }
                $insertarr['explog_points'] = 0;
                $exppoints_rule['exp_orderrate'] = floatval($exppoints_rule['exp_orderrate']);
                if ($insertarr['orderprice'] && $exppoints_rule['exp_orderrate'] > 0) {
                    $insertarr['explog_points'] = @intval($insertarr['orderprice'] / $exppoints_rule['exp_orderrate']);
                    $exp_ordermax = intval($exppoints_rule['exp_ordermax']);
                    if ($exp_ordermax > 0 && $insertarr['explog_points'] > $exp_ordermax) {
                        $insertarr['explog_points'] = $exp_ordermax;
                    }
                }
                break;
        }
        //新增日志
        $value_array = array();
        $value_array['explog_memberid'] = $insertarr['explog_memberid'];
        $value_array['explog_membername'] = $insertarr['explog_membername'];
        $value_array['explog_points'] = $insertarr['explog_points'];
        $value_array['explog_addtime'] = time();
        $value_array['explog_desc'] = $insertarr['explog_desc'];
        $value_array['explog_stage'] = $stage;
        $result = false;
        if ($value_array['explog_points'] != '0') {
            $result = self::addExppointslog($value_array);
        }
        if ($result) {
            //更新member内容
            $obj_member = model('member');
            $upmember_array = array();
            $upmember_array['member_exppoints'] = Db::raw('member_exppoints+'.$insertarr['explog_points']);
            $obj_member->editMember(array('member_id' => $insertarr['explog_memberid']), $upmember_array);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 添加经验值日志信息
     * @access public
     * @author csdeshang
     * @param array $data 添加信息数组
     * @return array
     */
    public function addExppointslog($data) {
        if (empty($data)) {
            return false;
        }
        $result = db('exppointslog')->insertGetId($data);
        return $result;
    }

    /**
     * 经验值日志总条数
     * @access public
     * @author csdeshang
     * @param array $where 条件数组
     * @param string $field 查询字段
     * @return int
     */
    public function getExppointslogCount($where, $field = '*') {
        $count = db('exppointslog')->field($field)->where($where)->count();
        return $count;
    }

    /**
     * 经验值日志列表
     * @access public
     * @author csdeshang
     * @param array $where 条件数组
     * @param string $field 查询字段
     * @param int $page 分页信息
     * @param string $order 排序
     * @return array
     */
    public function getExppointslogList($where, $field = '*', $page = 0, $order = '') {
        $result = db('exppointslog')->field($field)->where($where)->order($order)->paginate($page, false, ['query' => request()->param()]);
        $this->page_info = $result;
        $res = $result->items();
        return $res;
    }

    /**
     * 获得阶段说明文字
     * @access public
     * @author csdeshang
     * @return string
     */
    public function getExppointsStage() {
        $stage_arr = array();
        $stage_arr['login'] = '会员登录';
        $stage_arr['comments'] = '商品评论';
        $stage_arr['order'] = '订单消费';
        $stage_arr['system'] = '系统调整';
        return $stage_arr;
    }

}

?>
