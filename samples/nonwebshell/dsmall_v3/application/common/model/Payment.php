<?php

namespace app\common\model;

use think\Model;

class Payment extends Model {
    /**
     * 开启状态标识
     * @var unknown
     */
    const STATE_OPEN = 1;
    

    /**
     * 读取单行信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件数组
     * @return array 数组格式的返回结果
     */
    public function getPaymentInfo($condition = array()) {
        return db('payment')->where($condition)->find();
    }

    /**
     * 读开启中的取单行信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return type
     */
    public function getPaymentOpenInfo($condition = array()) {
        $condition['payment_state'] = self::STATE_OPEN;
        return db('payment')->where($condition)->find();
    }

    /**
     * 读取多行
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getPaymentList($condition = array()) {
        return db('payment')->where($condition)->select();
    }

    /**
     * 读取开启中的支付方式
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return array 数组格式的返回结果
     */
    public function getPaymentOpenList($condition = array()) {
        $condition['payment_state'] = self::STATE_OPEN;
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false) {
            //非微信内置浏览器,过滤微信支付
            $condition['payment_code'] = array('not in',array('wxpay_jsapi','wxpay_minipro','allinpay_h5')); 
        }else{
            //微信内置浏览器,过滤微信H5支付,以及支付宝H5支付
            if( strpos($_SERVER['HTTP_USER_AGENT'], 'miniprogram') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'miniProgram') !== false ){
                $condition['payment_code'] = array('not in',array('wxpay_h5','alipay_h5','wxpay_jsapi'));
           }else{
                $condition['payment_code'] = array('not in',array('wxpay_h5','alipay_h5'));
           }
        }
        return db('payment')->where($condition)->select();
    }
    
    /**
     * 新增支付方式
     * @access public
     * @author csdeshang
     * @param type $data 参数内容
     * @return type
     */
    public function addPayment($data){
        return db('payment')->insert($data);
    }
    
    /**
     * 删除支付方式
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return bool
     */
    public function delPayment($condition){
        return db('payment')->where($condition)->delete();
    }
    

    /**
     * 更新信息
     * @access public
     * @author csdeshang
     * @param array $data 更新数据
     * @param array $condition 更新条件
     * @return bool 布尔类型的返回结果
     */
    public function editPayment($data, $condition) {
        return db('payment')->where($condition)->update($data);
    }

    /**
     * 读取支付方式信息by Condition
     * @access public
     * @author csdeshang
     * @param type $conditionfield 条件字段
     * @param type $conditionvalue 条件值
     * @return type
     */
    public function getRowByCondition($conditionfield, $conditionvalue) {
        return db('payment')->where($conditionfield,$conditionvalue)->find();
    }

    /**
     * 获取支付方式
     * @access public
     * @author csdeshang
     * @staticvar type $payments
     * @return type
     */
    function get_builtin() {
        static $payments = null;
        if ($payments === null) {
            $payment_dir = PLUGINS_PATH . '/payments';
            $dir = dir($payment_dir);
            $payments = array();
            while (false !== ($entry = $dir->read())) {
                /* 隐藏文件，当前目录，上一级，排除 */
                if ($entry{0} == '.') {
                    continue;
                }
                /* 获取支付方式信息 */
                $payments[$entry] = $this->get_builtin_info($entry);
            }
        }
        return $payments;
    }
    
    /**
     * 获取内置支付方式的配置信息
     * @access public
     * @author csdeshang
     * @param type $code 编码
     * @return type
     */
    function get_builtin_info($code) {
        $payment_path = PLUGINS_PATH . '/payments/' . $code . '/payment.info.php';
        return include($payment_path);
    }

}

?>
