<?php

namespace app\common\model;
use think\Model;

class Webchat extends Model
{
   
    /**
     * 新增聊天记录
     * @access public
     * @author csdeshang
     * @param type $msg
     * @return type
     */
    public function addChatmsg($msg)
    {
        $msg['f_ip'] = request()->ip();
        $msg['r_state'] = '2';//state:1--read ,2--unread
        $msg['chatmsg_addtime'] = TIMESTAMP;
        $m_id = db('chatmsg')->insertGetId($msg);
        if ($m_id > 0) {
            $msg['m_id'] = $m_id;
            unset($msg['r_state']);
            unset($msg['chatmsg_addtime']);
            $msg['chatlog_addtime'] = TIMESTAMP;
            db('chatlog')->insertGetId($msg);
            $msg['m_id'] = $m_id;
            $msg['add_time'] = date('Y-m-d H:i:s', $msg['chatlog_addtime']);
            $t_msg = $msg['t_msg'];
            $goods_id = 0;
            $goods_info = array();
            $pattern = '#' . HOME_SITE_URL . '/goods/index.html?goods_id=(\d+)$#';
            preg_match($pattern, $t_msg, $matches);
            if (isset($matches[1]) && intval($matches[1]) < 1) {//伪静态
                $pattern = '#' . HOME_SITE_URL . '/item-(\d+)\.html$#';
                preg_match($pattern, $t_msg, $matches);
            }
            $goods_id = isset($matches[1])?intval($matches[1]):0;
            if ($goods_id >= 1) {
                $goods_info = $this->getGoodsInfo($goods_id);
                $goods_id = intval($goods_info['goods_id']);
            }
            $msg['goods_id'] = $goods_id;
            $msg['goods_info'] = $goods_info;
            return $msg;
        }
        else {
            return 0;
        }
    }

    /**
     * 单个用户信息
     * @access public
     * @author csdeshang
     * @param type $member_id 会员id
     * @return boolean|array
     */
    public function getMember($member_id)
    {
        if (intval($member_id) < 1) {
            return false;
        }
        $member = $this->getMemberInfo(array('member_id' => $member_id));
        return $member;
    }

    /**
     * 更新聊天消息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $data 数据
     * @return boolean
     */
    public function editChatmsg($condition, $data)
    {
        $m_id = $condition['m_id'];
        if (intval($m_id) < 1) {
            return false;
        }
        if (is_array($data) && !empty($data)) {
            $result = db('chatmsg')->where($condition)->update($data);
            return $result;
        }
        else {
            return false;
        }
    }

    /**
     * 获取聊天记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $page 分页
     * @param type $order 排序
     * @return type
     */
    public function getChatlogList($condition = array(), $page = 10, $order = 'm_id desc')
    {
        $list = db('chatlog')->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
        if (!empty($list->items()) && is_array($list->items())) {
            foreach ($list as $k => $v) {
                $v['time'] = date("Y-m-d H:i:s", $v['chatlog_addtime']);
                $list[$k] = $v;
            }
        }
        $this->page_info=$list;
        return $list->items();
    }

    /**
     * 记录详细
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getOneChatlog($condition)
    {
        return db('chatlog')->where($condition)->find();
    }

    /**
     * 取得我的好友
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $limit 限制
     * @param type $member_list 会员列表
     * @return array
     */
    public function getFriendList($condition = array(), $limit = 50, $member_list = array())
    {
        $list = db('snsfriend')->where($condition)->limit($limit)->order('friend_addtime desc')->select();
        if (!empty($list) && is_array($list)) {
            foreach ($list as $k => $v) {
                $member = array();
                $u_id = $v['friend_tomid'];
                $member['u_id'] = $u_id;
                $member['u_name'] = $v['friend_tomname'];
                $member['avatar'] = get_member_avatar_for_id($u_id);
                $member['friend'] = 1;
                $member_list[$u_id] = $member;
            }
        }
        return $member_list;
    }

    /**
     * 商家客服
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $page 分页
     * @param type $member_list 会员列表
     * @return type
     */
    public function getWebchatSellerList($condition = array(), $page = 50, $member_list = array())
    {
        $seller_model = model('seller');
        $list = $seller_model->getSellerList($condition, 'seller_id desc');
        if (!empty($list) && is_array($list)) {
            $member_ids = array();//会员编号数组
            foreach ($list as $k => $v) {
                $member = array();
                $u_id = $v['member_id'];
                $member_ids[] = $u_id;
                $member['u_id'] = $u_id;
                $member['u_name'] = '';
                $member['seller_id'] = $v['seller_id'];
                $member['seller_name'] = $v['seller_name'];
                $member['avatar'] = get_member_avatar_for_id($u_id);
                $member['seller'] = 1;
                $member_list[$u_id] = $member;
            }
            $member_model = model('member');
            $condition = array();
            $condition['member_id'] = array('in', $member_ids);
            $m_list = $member_model->getMemberList($condition);
            if (!empty($m_list) && is_array($m_list)) {
                foreach ($m_list as $key => $value) {
                    $u_id = $value['member_id'];//会员编号
                    $member_list[$u_id]['u_name'] = $value['member_name'];
                }
            }
        }
        return $member_list;
    }

    /**
     * 取得接受消息列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $limit 限制
     * @param type $member_list 会员列表
     * @return type
     */
    public function getRecentList($condition = array(), $limit = 5, $member_list = array())
    {
        $list = $this->getMemberRecentList($condition, '', $limit);
        if (!empty($list) && is_array($list)) {
            foreach ($list as $k => $v) {
                $member = array();
                $u_id = $v['t_id'];
                $member['u_id'] = $u_id;
                $member['u_name'] = $v['t_name'];
                $member['avatar'] = get_member_avatar_for_id($u_id);
                $member['recent'] = 1;
                $member['time'] = date("Y-m-d H:i:s", $v['addtime']);
                if (empty($member_list[$u_id])) {
                    $member_list[$u_id] = $member;
                }
                else {
                    $member_list[$u_id]['recent'] = 1;
                    $member_list[$u_id]['time'] = date("Y-m-d H:i:s", $v['addtime']);
                }
            }
        }
        return $member_list;
    }

    /**
     * 获取消息列表
     * @access public
     * @author csdeshang
     * @param type $condition
     * @param type $limit
     * @param type $member_list
     * @return type
     */
    public function getRecentFromList($condition = array(), $limit = 5, $member_list = array())
    {
        $list = $this->getMemberFromList($condition, '', $limit);
        if (!empty($list) && is_array($list)) {
            foreach ($list as $k => $v) {
                $member = array();
                $u_id = $v['f_id'];
                $member['u_id'] = $u_id;
                $member['u_name'] = $v['f_name'];
                $member['avatar'] = get_member_avatar_for_id($u_id);
                $member['recent'] = 1;
                $member['time'] = date("Y-m-d H:i:s", $v['addtime']);
                $member['r_state'] = $v['r_state'];
                if (empty($member_list[$u_id])) {
                    $member_list[$u_id] = $member;
                }
                else {
                    $member_list[$u_id]['recent'] = 1;
                    $member_list[$u_id]['time'] = date("Y-m-d H:i:s", $v['addtime']);
                    $member_list[$u_id]['r_state'] = $v['r_state'];
                }
            }
        }
        return $member_list;
    }

    /**
     * 收到消息的会员记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $page 分页
     * @param type $limit 限制
     * @return type
     */
    public function getMemberRecentList($condition = array(), $page = '', $limit = '')
    {
        $list = array();
        $msg = db('chatmsg')->field('count(DISTINCT t_id) as count')->where($condition)->find();
        if ($msg['count'] > 0) {
            $count = intval($msg['count']);
            $field = 't_id,t_name,max(chatmsg_addtime) as addtime';
            $list = db('chatmsg')->field($field)->group('t_id')->where($condition)->limit($limit)->page($page, $count)->order('addtime desc')->select();
        }
        return $list;
    }

    /**
     * 发出消息的会员记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $page 分页
     * @param type $limit 限制
     * @return type
     */
    public function getMemberFromList($condition = array(), $page = '', $limit = '')
    {
        $list = array();
        $msg = db('chatmsg')->field('count(DISTINCT f_id) as count')->where($condition)->find();
        if ($msg['count'] > 0) {
            $count = intval($msg['count']);
            $field = 'r_state,f_id,f_name,max(chatmsg_addtime) as addtime';
            $list = db('chatmsg')->field($field)->group('f_id')->where($condition)->limit($limit)->page($page, $count)->order('addtime desc')->select();
        }
        return $list;
    }

    /**
     * 单个会员的消息记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $page 分页
     * @param type $order 排序
     * @return type
     */
    public function getChatlogFromList($condition = array(), $page = 10, $order = 'm_id desc')
    {
        $list = array();
        $f_id = intval($condition['f_id']);
        if ($f_id > 0) {
            $t_id = intval($condition['t_id']);
            if ($t_id > 0) {
                $condition_sql = " ((f_id = '" . $f_id . "' and t_id = '" . $t_id . "') or (f_id = '" . $t_id . "' and t_id = '" . $f_id . "'))";
            }
            else {
                $condition_sql = " (f_id = '" . $f_id . "' or t_id = '" . $f_id . "')";
            }
            $add_time_from = trim($condition['add_time_from']);
            if (!empty($add_time_from)) {
                $add_time_from = strtotime($add_time_from);
                $condition_sql .= " and chatlog_addtime >= '" . $add_time_from . "'";
            }
            $add_time_to = trim($condition['add_time_to']);
            if (!empty($add_time_to)) {
                $add_time_to = strtotime($add_time_to) + 60 * 60 * 24;
                $condition_sql .= " and chatlog_addtime <= '" . $add_time_to . "'";
            }
            $t_msg = isset($condition['t_msg'])?trim($condition['t_msg']):'';
            if (!empty($t_msg)) {
                $condition_sql .= " and t_msg like '%" . $t_msg . "%'";
            }
            $list = $this->getChatlogList($condition_sql, $page, $order);
        }
        return $list;
    }

    /**
     * 会员相关的信息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getMemberInfo($condition)
    {
        $member_model = model('member');
        $member = $member_model->getMemberInfo($condition, 'member_id,member_name,member_avatar');
        if(empty($member)){
            return;
        }
        $member['store_id'] = '';
        $member['store_name'] = '';
        $member['store_avatar'] = '';
        $member['grade_id'] = '';
        $member['member_avatar'] = get_member_avatar($member['member_avatar']);
        $seller_model = model('seller');
        $seller = $seller_model->getSellerInfo(array('member_id' => $member['member_id']));
        if (!empty($seller) && $seller['store_id'] > 0) {
            $store_info = db('store')->field('store_id,store_name,grade_id,store_avatar')->where(array('store_id' => $seller['store_id']))->find();
            if (is_array($store_info) && !empty($store_info)) {
                $member['store_id'] = $store_info['store_id'];
                $member['store_name'] = $store_info['store_name'];
                $member['seller_name'] = $seller['seller_name'];
                $member['grade_id'] = $store_info['grade_id'];
                $member['store_avatar'] = get_store_logo($store_info['store_avatar']);
            }
        }
        return $member;
    }

    /**
     * 商品相关的信息
     * @access public
     * @author csdeshang
     * @param type $goods_id 商品id
     * @return type
     */
    public function getGoodsInfo($goods_id)
    {
        $goods = array();
        $goods_model = model('goods');
        $goods_id = intval($goods_id);
        $goods = $goods_model->getGoodsInfoByID($goods_id);
        if (is_array($goods) && !empty($goods)) {
            $goods['url'] = url('Home/Goods/index',['goods_id'=>$goods['goods_id']]);
            $goods['goods_promotion_price'] = ds_price_format($goods['goods_promotion_price']);
            $goods['pic'] = goods_thumb($goods, 60);
            $goods['pic24'] = goods_thumb($goods, 240);
        }
        return $goods;
    }

    /**
     * 获取聊天记录数
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getChatmsgCount($condition)
    {
        return (int)db('chatmsg')->where($condition)->count();
    }
    
    /**
     * 删除聊天记录
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return bool
     */
    public function delChatmsg($condition)
    {
        if(empty($condition)){
            return;
        }
        return db('chatmsg')->where($condition)->delete();
    }
    
}