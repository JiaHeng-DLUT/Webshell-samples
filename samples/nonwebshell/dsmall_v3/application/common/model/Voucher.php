<?php

namespace app\common\model;
use think\Model;
use think\Db;
class Voucher extends Model
{

    const VOUCHER_STATE_UNUSED = 1;
    const VOUCHER_STATE_USED = 2;
    const VOUCHER_STATE_EXPIRE = 3;
    public $page_info;
    private $voucher_state_array = array(
        self::VOUCHER_STATE_UNUSED => '未使用', self::VOUCHER_STATE_USED => '已使用', self::VOUCHER_STATE_EXPIRE => '已过期',
    );

    const VOUCHER_GETTYPE_DEFAULT = 'points'; //默认领取方式

    private $voucher_gettype_array = array(
        'points' => array('sign' => 1, 'name' => '积分兑换'), 'pwd' => array('sign' => 2, 'name' => '卡密兑换'),
        'free' => array('sign' => 3, 'name' => '免费领取')
    );
    private $quotastate_arr;
    private $templatestate_arr;

    /**
     * 构造函数
     * @access public
     * @author csdeshang
     */
    public function __construct()
    {
        parent::__construct();
        //套餐状态
        $this->quotastate_arr = array(
            'activity' => array(1, lang('voucher_quotastate_activity')),
            'cancel' => array(2, lang('voucher_quotastate_cancel')),
            'expire' => array(3, lang('voucher_quotastate_expire'))
        );
        //代金券模板状态
        $this->templatestate_arr = array('usable' => array(1, '有效'), 'disabled' => array(2, '失效'));
    }

    /**
     * 获取代金券模板状态
     * @access public
     * @author csdeshang
     * @return type
     */
    public function getTemplateState()
    {
        return $this->templatestate_arr;
    }

    /**
     * 领取的代金券状态
     * @access public
     * @author csdeshang
     * @return type
     */
    public function getVoucherState()
    {
        return array(
            'unused' => array(1, lang('voucher_voucher_state_unused')),
            'used' => array(2, lang('voucher_voucher_state_used')),
            'expire' => array(3, lang('voucher_voucher_state_expire'))
        );
    }

    /**
     * 返回当前可用的代金券列表,每种类型(模板)的代金券里取出一个代金券码(同一个模板所有码面额和到期时间都一样)
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param int $goods_total 商品总金额
     * @return string
     */
    public function getCurrentAvailableVoucher($condition = array(), $goods_total = 0)
    {
        $condition['voucher_enddate'] = array('gt', TIMESTAMP);
        $condition['voucher_state'] = 1;
        
        $voucher_list = db('voucher')->where($condition)->select();
        if(!empty($voucher_list)){
            $voucher_list = ds_change_arraykey($voucher_list,'vouchertemplate_id');
        }
        
        foreach ($voucher_list as $key => $voucher) {
            if ($goods_total < $voucher['voucher_limit']) {
                unset($voucher_list[$key]);
            }
            else {
                $voucher_list[$key]['desc'] = sprintf('面额%s元 有效期至 %s ', $voucher['voucher_price'], date('Y-m-d', $voucher['voucher_enddate']));
                if ($voucher['voucher_limit'] > 0) {
                    $voucher_list[$key]['desc'] .= sprintf(' 消费满%s可用', $voucher['voucher_limit']);
                }
            }
        }
        return $voucher_list;
    }

    /**
     * 取得当前有效代金券数量
     * @access public
     * @author csdeshang
     * @param type $member_id 会员ID
     * @return type
     */
    public function getCurrentAvailableVoucherCount($member_id)
    {
        $info = rcache($member_id, 'm_voucher');
        if (empty($info)) {
            $condition['voucher_owner_id'] = $member_id;
            $condition['voucher_enddate'] = array('gt', TIMESTAMP);
            $condition['voucher_state'] = 1;
            $voucher_count = db('voucher')->where($condition)->count();
            $voucher_count = intval($voucher_count);
            wcache($member_id, array('voucher_count' => $voucher_count), 'm_voucher');
        }
        else {
            $voucher_count = intval($info['voucher_count']);
        }
        return $voucher_count;
    }

    /**
     * 查询当前可用的套餐
     * @access public
     * @author csdeshang
     * @param type $store_id 店铺ID
     * @return boolean|array
     */
    public function getVoucherquotaCurrent($store_id)
    {
        $store_id = intval($store_id);
        if ($store_id <= 0) {
            return false;
        }
        $where = array();
        $where['voucherquota_storeid'] = $store_id;
        $where['voucherquota_endtime'] = array('gt', TIMESTAMP);
        $info = db('voucherquota')->where($where)->find();
        return $info;
    }


    
    /**
     * 获得代金券列表
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $field 字段
     * @return type
     */
    public function getVoucherList($where, $field = '*')
    {
        $voucher_list = array();
        $voucher_list = db('voucher')->field($field)->where($where)->select();
        return $voucher_list;
    }
    
    /**
     * 获取失效代金卷列表
     * @access public
     * @author csdeshang
     * @param array $where 条件
     * @param type $field 字段
     * @return type
     */
    public function getVoucherUnusedList($where, $field = '*')
    {
        $where['voucher_state'] = 1;
        return $this->getVoucherList($where, $field);
    }

    /**
     * 查询可兑换代金券模板详细信息，包括店铺信息
     * @access public
     * @author csdeshang
     * @param type $vid
     * @param type $member_id 会员id
     * @param type $store_id 店铺id
     * @return type
     */
    public function getCanChangeTemplateInfo($vid, $member_id, $store_id = 0)
    {
        if ($vid <= 0 || $member_id <= 0) {
            return array('state' => false, 'msg' => '参数错误');
        }
        //查询可用代金券模板
        $where = array();
        $where['vouchertemplate_id'] = $vid;
        $where['vouchertemplate_state'] = $this->templatestate_arr['usable'][0];
        $where['vouchertemplate_enddate'] = array('gt', time());
        $template_info = $this->getVouchertemplateInfo($where);
        if (empty($template_info) || $template_info['vouchertemplate_total'] <= $template_info['vouchertemplate_giveout']) {//代金券不存在或者已兑换完
            return array('state' => false, 'msg' => '代金券已兑换完');
        }
        //验证是否为店铺自己
        if ($store_id > 0 && $store_id == $template_info['vouchertemplate_store_id']) {
            return array('state' => false, 'msg' => '不可以兑换自己店铺的代金券');
        }
        $member_model = model('member');
        $member_info = $member_model->getMemberInfoByID($member_id);
        if (empty($member_info)) {
            return array('state' => false, 'msg' => '参数错误');
        }
        //验证会员积分是否足够
        if ($template_info['vouchertemplate_gettype'] == $this->voucher_gettype_array['points']['sign'] && $template_info['vouchertemplate_points'] > 0) {
            if (intval($member_info['member_points']) < intval($template_info['vouchertemplate_points'])) {
                return array('state' => false, 'msg' => '您的积分不足，暂时不能兑换该代金券');
            }
        }
        //验证会员级别
        /*
        $member_currgrade = $member_model->getOneMemberGrade(intval($member_info['member_exppoints']));
        $member_info['member_currgrade'] = $member_currgrade ? $member_currgrade['level'] : 0;
        if ($member_info['member_currgrade'] < intval($template_info['vouchertemplate_mgradelimit'])) {
            return array('state' => false, 'msg' => '您的会员级别不够，暂时不能兑换该代金券');
        }
         */
        
        //查询代金券对应的店铺信息
        $store_info = model('store')->getStoreInfoByID($template_info['vouchertemplate_store_id']);
        if (empty($store_info)) {
            return array('state' => false, 'msg' => '代金券已兑换完');
        }
        //整理代金券信息
        $template_info = array_merge($template_info, $store_info);
        //查询代金券列表
        $where = array();
        $where['voucher_owner_id'] = $member_id;
        $where['voucher_store_id'] = $template_info['vouchertemplate_store_id'];

        $voucher_list = $this->getVoucherList($where);
        //halt($voucher_list);
        if (!empty($voucher_list)) {
            $voucher_count = 0; //在该店铺兑换的代金券数量
            $voucherone_count = 0; //该张代金券兑换的数量
            foreach ($voucher_list as $k => $v) {
                //如果代金券未用且未过期
                if ($v['voucher_state'] == 1 && $v['voucher_enddate'] > time()) {
                    $voucher_count += 1;
                }
                if ($v['vouchertemplate_id'] == $template_info['vouchertemplate_id']) {
                    $voucherone_count += 1;
                }
            }

            //买家最多只能拥有同一个店铺尚未消费抵用的店铺代金券最大数量的验证
            if ($voucher_count >= intval(config('voucher_buyertimes_limit'))) {
                $message = sprintf('您的可用代金券已有%s张,不可再兑换了', config('voucher_buyertimes_limit'));
                return array('state' => false, 'msg' => $message);
            }
            //同一张代金券最多能兑换的次数
            if (!empty($template_info['vouchertemplate_eachlimit']) && $voucherone_count >= $template_info['vouchertemplate_eachlimit']) {
                $message = sprintf('该代金券您已兑换%s次，不可再兑换了', $template_info['vouchertemplate_eachlimit']);
                return array('state' => false, 'msg' => $message);
            }
        }
        return array('state' => true, 'info' => $template_info);
    }

    /**
     * 获取代金券编码
     * @access public
     * @author csdeshang
     * @staticvar int $num
     * @param type $member_id 会员id
     * @return type
     */
    public function getVoucherCode($member_id = 0)
    {
        static $num = 1;
        $sign_arr = array();
        $sign_arr[] = sprintf('%02d', mt_rand(10, 99));
        $sign_arr[] = sprintf('%03d', (float)microtime() * 1000);
        $sign_arr[] = sprintf('%010d', time() - 946656000);
        if ($member_id) {
            $sign_arr[] = sprintf('%03d', (int)$member_id % 1000);
        }
        else {
            //自增变量
            $tmpnum = 0;
            if ($num > 99) {
                $tmpnum = substr($num, -1, 2);
            }
            else {
                $tmpnum = $num;
            }
            $sign_arr[] = sprintf('%02d', $tmpnum);
            $sign_arr[] = mt_rand(1, 9);
        }
        $code = implode('', $sign_arr);
        $num += 1;
        return $code;
    }

    /**
     * 生成代金券卡密
     * @staticvar int $num
     * @param type $vouchertemplate_id 卡密ID编号
     * @return boolean|array
     */
    public function createVoucherPwd($vouchertemplate_id)
    {
        if ($vouchertemplate_id <= 0) {
            return false;
        }
        static $num = 1;
        $sign_arr = array();
        //时间戳
        $time_tmp = uniqid('', true);
        $time_tmp = explode('.', $time_tmp);
        $sign_arr[] = substr($time_tmp[0], -1, 4) . $time_tmp[1];
        //自增变量
        $tmpnum = 0;
        if ($num > 999) {
            $tmpnum = substr($num, -1, 3);
        }
        else {
            $tmpnum = $num;
        }
        $sign_arr[] = sprintf('%03d', $tmpnum);
        //代金券模板ID
        if ($vouchertemplate_id > 9999) {
            $vouchertemplate_id = substr($num, -1, 4);
        }
        $sign_arr[] = sprintf('%04d', $vouchertemplate_id);
        //随机数
        $sign_arr[] = sprintf('%04d', rand(1, 9999));
        $pwd = implode('', $sign_arr);
        $num += 1;
        return array(md5($pwd), ds_encrypt($pwd));
    }

    /**
     * 生成代金券卡密
     * @access public
     * @author csdeshang
     * @param type $pwd 卡密
     * @return string
     */
    public function getVoucherPwd($pwd)
    {
        if (!$pwd) {
            return '';
        }
        $pwd = ds_decrypt($pwd);
        $pattern = "/^([0-9]{20})$/i";
        if (preg_match($pattern, $pwd)) {
            return $pwd;
        }
        else {
            return '';
        }
    }

    /**
     * 更新代金券信息
     * @param type $data 数据
     * @param type $condition 条件
     * @param type $member_id 会员id
     * @return type
     */
    public function editVoucher($data, $condition, $member_id = 0)
    {
        $result = db('voucher')->where($condition)->update($data);
        if ($result && $member_id > 0) {
            wcache($member_id, array('voucher_count' => null), 'm_voucher');
        }
        return $result;
    }

    /**
     * 返回代金券状态数组
     * @access public
     * @author csdeshang
     * @return array
     */
    public function getVoucherStateArray()
    {
        return $this->voucher_state_array;
    }

    /**
     * 返回代金券领取方式数组
     * @access public
     * @author csdeshang
     * @return array
     */
    public function getVoucherGettypeArray()
    {
        return $this->voucher_gettype_array;
    }

    /**
     * 获取买家代金券列表
     * @access public
     * @author csdeshang
     * @param int $member_id 用户编号
     * @param int $voucher_state 代金券状态
     * @param int $page 分页数
     * @return array
     */
    public function getMemberVoucherList($member_id, $voucher_state, $page = null)
    {
        if (empty($member_id)) {
            return false;
        }

        //更新过期代金券状态
        $this->_checkVoucherExpire($member_id);

        $where = array('voucher_owner_id' => $member_id);
        $voucher_state = intval($voucher_state);
        if (intval($voucher_state) > 0 && array_key_exists($voucher_state, $this->voucher_state_array)) {
            $where['voucher_state'] = $voucher_state;
        }

       $list = db('voucher')->alias('v')->join('__STORE__ s','s.store_id=v.voucher_store_id')->join('__VOUCHERTEMPLATE__ t','v.vouchertemplate_id=t.vouchertemplate_id')->where($where)->order('voucher_id desc')->paginate($page,false,['query' => request()->param()]);
        $this->page_info=$list;
        $list=$list->items();
        if (!empty($list) && is_array($list)) {
            foreach ($list as $key => $val) {
                //代金券图片
                if (empty($val['vouchertemplate_customimg']) || !file_exists(BASE_UPLOAD_PATH . DS . ATTACH_VOUCHER . DS . $val['store_id'] . DS . $val['vouchertemplate_customimg'])) {
                    $list[$key]['vouchertemplate_customimg'] = UPLOAD_SITE_URL . DS . default_goodsimage(60);
                }
                else {
                    $list[$key]['vouchertemplate_customimg'] = UPLOAD_SITE_URL . DS . ATTACH_VOUCHER . DS . $val['store_id'] . DS .$val['vouchertemplate_customimg'];
                }
                //代金券状态文字
                $list[$key]['voucher_state_text'] = $this->voucher_state_array[$val['voucher_state']];
                $list[$key]['voucher_end_date_text'] = $val['voucher_enddate'] ? @date('Y.m.d', $val['voucher_enddate']) : '';
            }
        }
        return $list;
    }

    /**
     * 更新过期代金券状态
     * @access public
     * @author csdeshang
     * @param type $member_id 会员ID
     * @return type 
     */
    private function _checkVoucherExpire($member_id)
    {
        $condition = array();
        $condition['voucher_owner_id'] = $member_id;
        $condition['voucher_state'] = self::VOUCHER_STATE_UNUSED;
        $condition['voucher_enddate'] = array('lt', TIMESTAMP);

        db('voucher')->where($condition)->update(array('voucher_state' => self::VOUCHER_STATE_EXPIRE));
    }

    /**
     * 查询代金券模板列表
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $field 字段
     * @param type $limit 限制
     * @param type $page 分页
     * @param type $order 排序
     * @return type
     */
    public function getVouchertemplateList($where, $field = '*', $limit = 0, $page = 0, $order = '')
    {
        $voucher_list = array();
        if ($page) {
            $result = db('vouchertemplate')->field($field)->where($where)->order($order)->paginate(10, false, ['query' => request()->param()]);
            $voucher_list = $result->items();
            $this->page_info = $result;
        } else {
            $voucher_list = db('vouchertemplate')->field($field)->where($where)->limit($limit)->order($order)->select();
        }

        //查询店铺分类
        $store_class = rkcache('storeclass', true);

        if (!empty($voucher_list) && is_array($voucher_list)) {
            foreach ($voucher_list as $k => $v) {
                if (!empty($v['vouchertemplate_customimg'])) {
                    $v['vouchertemplate_customimg'] = UPLOAD_SITE_URL . DS . ATTACH_VOUCHER . DS . $v['vouchertemplate_store_id'] . DS . $v['vouchertemplate_customimg'];
                }
                else {
                    $v['vouchertemplate_customimg'] = UPLOAD_SITE_URL . DS . default_goodsimage(240);
                }
                $v['vouchertemplate_sc_name'] = isset($store_class[$v['vouchertemplate_sc_id']])?$store_class[$v['vouchertemplate_sc_id']]['storeclass_name']:'';
                //领取方式
                if ($v['vouchertemplate_gettype']) {
                    foreach ($this->voucher_gettype_array as $gtype_k => $gtype_v) {
                        if ($v['vouchertemplate_gettype'] == $gtype_v['sign']) {
                            $v['vouchertemplate_gettype_key'] = $gtype_k;
                            $v['vouchertemplate_gettype_text'] = $gtype_v['name'];
                        }
                    }
                }
                //状态
                if ($v['vouchertemplate_state']) {
                    foreach ($this->templatestate_arr as $tstate_k => $tstate_v) {
                        if ($v['vouchertemplate_state'] == $tstate_v[0]) {
                            $v['vouchertemplate_state_text'] = $tstate_v[1];
                        }
                    }
                }
                
                //会员级别
                /*
                $member_grade = model('member')->getMemberGradeArr();
                $v['vouchertemplate_mgradelimittext'] = isset($v['vouchertemplate_mgradelimit']) ? $member_grade[$v['vouchertemplate_mgradelimit']]['level_name'] : '';
                 */

                $voucher_list[$k] = $v;
            }
        }
        return $voucher_list;
    }

   
    /**
     * 更新代金券模板信息
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $data 数据
     * @return type
     */
    public function editVouchertemplate($where, $data)
    {
        return db('vouchertemplate')->where($where)->update($data);
    }

    /**
     * 获得代金券面额列表
     * @access public
     * @author csdeshang
     * @return type
     */
    public function getVoucherPriceList($page='',$order='voucherprice asc')
    {
        if($page){
            $voucherprice_list = db('voucherprice')->order('voucherprice asc')->paginate(10, false, ['query' => request()->param()]);
            $this->page_info = $voucherprice_list;
            return $voucherprice_list->items();
        } else {
            return db('voucherprice')->order('voucherprice asc')->select();
        }
        
    }

    /**
     * 获得推荐的热门代金券列表
     * @access public
     * @author csdeshang
     * @param int $num 查询条数
     * @return array 
     */
    public function getRecommendTemplate($num)
    {
        //查询推荐的热门代金券列表
        $where = array();
        $where['vouchertemplate_state'] = $this->templatestate_arr['usable'][0];
        //领取方式为积分兑换
        $where['vouchertemplate_gettype'] = $this->voucher_gettype_array['points']['sign'];
        $where['vouchertemplate_enddate'] = array('gt', time());
        $recommend_voucher = $this->getVouchertemplateList($where, $field = '*', $num, 0, 'vouchertemplate_recommend desc,vouchertemplate_id desc');
        return $recommend_voucher;
    }

    /**
     * 积分兑换代金券
     * @access public
     * @author csdeshang
     * @param type $template_info 信息模板
     * @param type $member_id 会员ID
     * @param type $member_name 会员名
     * @return type
     */
    public function exchangeVoucher($template_info, $member_id, $member_name = '')
    {
        if (intval($member_id) <= 0 || empty($template_info)) {
            return array('state' => false, 'msg' => '参数错误');
        }
        //查询会员信息
        if (!$member_name) {
            $member_info = model('member')->getMemberInfoByID($member_id);
            if (empty($template_info)) {
                return array('state' => false, 'msg' => '参数错误');
            }
            $member_name = $member_info['member_name'];
        }
        //添加代金券信息
        $insert_arr = array();
        $insert_arr['voucher_code'] = $this->getVoucherCode($member_id);
        $insert_arr['vouchertemplate_id'] = $template_info['vouchertemplate_id'];
        $insert_arr['voucher_title'] = $template_info['vouchertemplate_title'];
        $insert_arr['voucher_desc'] = $template_info['vouchertemplate_desc'];
        $insert_arr['voucher_startdate'] = TIMESTAMP;
        $insert_arr['voucher_enddate'] = $template_info['vouchertemplate_enddate'];
        $insert_arr['voucher_price'] = $template_info['vouchertemplate_price'];
        $insert_arr['voucher_limit'] = $template_info['vouchertemplate_limit'];
        $insert_arr['voucher_store_id'] = $template_info['vouchertemplate_store_id'];
        $insert_arr['voucher_state'] = 1;
        $insert_arr['voucher_activedate'] = TIMESTAMP;
        $insert_arr['voucher_owner_id'] = $member_id;
        $insert_arr['voucher_owner_name'] = $member_name;
        $result = db('voucher')->insertGetId($insert_arr);
        if (!$result) {
            return array('state' => false, 'msg' => '兑换失败');
        }
        //扣除会员积分
        if ($template_info['vouchertemplate_points'] > 0 && $template_info['vouchertemplate_gettype'] == $this->voucher_gettype_array['points']['sign']) {
            $points_arr['pl_memberid'] = $member_id;
            $points_arr['pl_membername'] = $member_name;
            $points_arr['pl_points'] = -$template_info['vouchertemplate_points'];
            $points_arr['point_ordersn'] = $insert_arr['voucher_code'];
            $points_arr['pl_desc'] = lang('home_voucher') . $insert_arr['voucher_code'] . lang('points_pointorderdesc');
            $result = model('points')->savePointslog('app', $points_arr, true);
            if (!$result) {
                return array('state' => false, 'msg' => '兑换失败');
            }
        }
        if ($result) {
            //代金券模板的兑换数增加
            $result = $this->editVouchertemplate(array('vouchertemplate_id' => $template_info['vouchertemplate_id']), array(
                'vouchertemplate_giveout' => Db::raw('vouchertemplate_giveout+1')
            ));
            if (!$result) {
                return array('state' => false, 'msg' => '兑换失败');
            }
            return array('state' => true, 'msg' => '兑换成功');
        }
        else {
            return array('state' => false, 'msg' => '兑换失败');
        }
    }

    /**
     * 批量增加代金券
     * @access public
     * @author csdeshang
     * @param type $insert_arr 参数数据
     * @return type
     */
    public function addVoucherBatch($insert_arr)
    {
        return db('voucher')->insertAll($insert_arr);
    }

    /**
     * 获得代金券模板总数量
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @return int
     */
    public function getVouchertemplateCount($where)
    {
        return db('vouchertemplate')->where($where)->count();
    }

    /**
     * 获得代金券总数量
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @return int
     */
    public function getVoucherCount($where)
    {
        return db('voucher')->where($where)->count();
    }

    /**
     * 获得代金券模板详情
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $field 字段
     * @param type $order 排序
     * @return array
     */
    public function getVouchertemplateInfo($where = array(), $field = '*', $order = '')
    {
        $info = db('vouchertemplate')->where($where)->field($field)->order($order)->find();
        if (!$info) {
            return array();
        }
        if ($info['vouchertemplate_gettype']) {
            foreach ($this->voucher_gettype_array as $k => $v) {
                if ($info['vouchertemplate_gettype'] == $v['sign']) {
                    $info['vouchertemplate_gettype_key'] = $k;
                    $info['vouchertemplate_gettype_text'] = $v['name'];
                }
            }
        }
        if ($info['vouchertemplate_state']) {
            foreach ($this->templatestate_arr as $k => $v) {
                if ($info['vouchertemplate_state'] == $v[0]) {
                    $info['vouchertemplate_state_text'] = $v[1];
                }
            }
        }
        //查询店铺分类
        if ($info['vouchertemplate_sc_id']) {
            $store_class = rkcache('storeclass', true);
            $info['vouchertemplate_sc_name'] = $store_class[$info['vouchertemplate_sc_id']]['storeclass_name'];
        }
        if (!empty($info['vouchertemplate_customimg'])) {
            $info['vouchertemplate_customimg'] = UPLOAD_SITE_URL . DS . ATTACH_VOUCHER . DS . $info['vouchertemplate_store_id'] . DS . $info['vouchertemplate_customimg'];
        }
        else {
            $info['vouchertemplate_customimg'] = UPLOAD_SITE_URL . DS . default_goodsimage(240);
        }
        
        //会员等级
        /*
        $member_grade = model('member')->getMemberGradeArr();
        $info['vouchertemplate_mgradelimittext'] = isset($info['vouchertemplate_mgradelimit'])?$member_grade[$info['vouchertemplate_mgradelimit']]['level_name']:'';
        */
        return $info;
    }

    /**
     * 获得代金券详情
     * @access public
     * @author csdeshang
     * @param type $where 条件
     * @param type $field 字段
     * @param type $order 排序
     * @return type
     */
    public function getVoucherInfo($where = array(), $field = '*', $order = '')
    {
        $info = db('voucher')->where($where)->field($field)->order($order)->find();
        if ($info['voucher_state']) {
            $info['voucher_state_text'] = $this->voucher_state_array[$info['voucher_state']];
        }
        return $info;
    }
    
    /**
     * 获取单个代金券
     * @param type $where
     * @return type
     */
    public function getOneVoucherprice($condition = array()){
        return db('voucherprice')->where($condition)->find();
    }
    
    /**
     * 增加代金券面额
     * @param type $data
     * @return type
     */
    public function addVoucherprice($data){
        return db('voucherprice')->insert($data);
    }
    /**
     * 修改代金券面额
     * @param type $where
     * @param type $data
     * @return type
     */
    public function editVoucherprice($condition,$data){
        return db('voucherprice')->where($condition)->update($data);
    }
    
    /**
     * 删除代金券
     * @param type $condition
     * @return type
     */
    public function delVoucherprice($condition){
        return db('voucherprice')->where($condition)->delete();
    }
    
    /**
     * 更新代金券
     * @param type $condition
     * @param type $data
     * @return type
     */
    public function editVoucherquota($condition,$data){
        return db('voucherquota')->where($condition)->update($data);
    }
    
    /**
     * 获取代金券套餐列表
     * @param type $condition
     * @param type $page
     * @param type $order
     * @return type
     */
    public function getVoucherquotaList($condition,$page,$order){
        if($page){
            $voucherquota_list = db('voucherquota')->where($condition)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $voucherquota_list;
            return $voucherquota_list->items();
        } else {
            $voucherquota_list = db('voucherquota')->where($condition)->order($order)->select();
            return $voucherquota_list;
        }       
    }
    


}

?>
