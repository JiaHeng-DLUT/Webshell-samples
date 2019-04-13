<?php

/**
 * 取得商品缩略图的完整URL路径，接收商品信息数组，返回所需的商品缩略图的完整URL
 *
 * @param array $goods 商品信息数组
 * @param string $type 缩略图类型  值为240,480,1280
 * @return string
 */
function goods_thumb($goods = array(), $type = '')
{
    $type_array = explode(',_', ltrim(GOODS_IMAGES_EXT, '_'));
    if ($type!='0' && !in_array($type, $type_array) && !empty($type)) {
        $type = '240';
    }

    if (empty($goods)) {
        return UPLOAD_SITE_URL . '/' . default_goodsimage('normal');
    }
    if (array_key_exists('apic_cover', $goods)) {
        $goods['goods_image'] = $goods['apic_cover'];
    }

    if (empty($goods['goods_image'])) {
        return UPLOAD_SITE_URL . '/' . default_goodsimage('normal');
    }
    $file = $goods['goods_image'];
    $fname = basename($file);

    //对象存储文件
    $upload_type = explode('_', $fname);
    if (in_array($upload_type['0'], array('alioss', 'cos'))) {
        $store_id = $upload_type['1'];
        $aliendpoint_type = config('aliendpoint_type');
        if($aliendpoint_type) {
            return HTTP_TYPE.config($upload_type['0'] . '_endpoint') . '/' . ATTACH_GOODS . '/' . $store_id . '/' . $file;
        }else{
            return 'https://'.config($upload_type['0'] . '_bucket').'.'.config($upload_type['0'] . '_endpoint') . '/' . ATTACH_GOODS . '/' . $store_id . '/' . $file;
        }
    }
    //取店铺ID
    if (preg_match('/^(\d+_)/', $fname)) {
        $store_id = substr($fname, 0, strpos($fname, '_'));
    }
    else {
        $store_id = $goods['store_id'];
    }

    $thumb_host = UPLOAD_SITE_URL . '/' . ATTACH_GOODS;
    if (!file_exists(BASE_UPLOAD_PATH . '/' . ATTACH_GOODS . '/' . $store_id . '/' . str_ireplace('.', '_' . $type . '.', $file))) {
        if(!file_exists(BASE_UPLOAD_PATH . '/' . ATTACH_GOODS . '/' . $store_id . '/' . $file)){
            return UPLOAD_SITE_URL . '/' . default_goodsimage('normal');
        }else{
            return $thumb_host . '/' . $store_id . '/' . $file;
        }
    }
    
    return $thumb_host . '/' . $store_id . '/' . ($type == '' ? $file : str_ireplace('.', '_' . $type . '.', $file));
}

/**
 * 取得商品缩略图的完整URL路径，接收图片名称与店铺ID
 *
 * @param string $file 图片名称
 * @param string $type 缩略图尺寸类型，值为240,480,1280
 * @param mixed $store_id 店铺ID 如果传入，则返回图片完整URL,如果为假，返回系统默认图
 * @return string
 */
function goods_cthumb($file, $type = '', $store_id = false)
{
    $type_array = explode(',_', ltrim(GOODS_IMAGES_EXT, '_'));
    if ($type!='0' && !in_array($type, $type_array) && !empty($type)) {
        $type = '240';
    }
    if (empty($file)) {
        return UPLOAD_SITE_URL . '/' . default_goodsimage('normal');
    }
    $fname = basename($file);
    // 取店铺ID
    $upload_type = explode('_', $fname);
    //外网存储图片
    if (in_array($upload_type['0'], array('alioss', 'cos'))) {
        $store_id = $upload_type['1'];
        $aliendpoint_type = config('aliendpoint_type');
        if($aliendpoint_type) {
            return HTTP_TYPE.config($upload_type['0'] . '_endpoint') . '/' . ATTACH_GOODS . '/' . $store_id . '/' . $file;
        }else{
            return 'https://'.config($upload_type['0'] . '_bucket').'.'.config($upload_type['0'] . '_endpoint') . '/' . ATTACH_GOODS . '/' . $store_id . '/' . $file;
        }
    }
    
    if ($store_id === false || !is_numeric($store_id)) {
        $store_id = substr($fname, 0, strpos($fname, '_'));
    }
    // 本地存储时，增加判断文件是否存在，用默认图代替
    $thumb_host = UPLOAD_SITE_URL . '/' . ATTACH_GOODS;
    if (!file_exists(BASE_UPLOAD_PATH . '/' . ATTACH_GOODS . '/' . $store_id . '/' . ($type == '' ? $file : str_ireplace('.', '_' . $type . '.', $file)))) {
        if(!file_exists(BASE_UPLOAD_PATH . '/' . ATTACH_GOODS . '/' . $store_id . '/' . $file)){
            return UPLOAD_SITE_URL . '/' . default_goodsimage('normal');
        }else{
            return $thumb_host . '/' . $store_id . '/' . $file;
        }
        return UPLOAD_SITE_URL . '/' . default_goodsimage('normal');
    }
    
    return $thumb_host . '/' . $store_id . '/' . ($type == '' ? $file : str_ireplace('.', '_' . $type . '.', $file));
}

/**
 * 商品二维码
 * @param array $goods_info
 * @return string
 */
function goods_qrcode($goods_info)
{
    return HOME_SITE_URL.'/qrcode?url='. urlencode(WAP_SITE_URL.'/mall/product_detail.html?goods_id='.$goods_info['goods_id']);
}

/**
 * 商品二维码
 * @param array $goods_info
 * @return string
 */
function store_qrcode($store_id)
{
    return HOME_SITE_URL.'/qrcode?url='. urlencode(WAP_SITE_URL.'/mall/store.html?store_id='.$store_id);
}

/**
 * 取得抢购缩略图的完整URL路径
 *
 * @param string $imgurl 商品名称
 * @param string $type 缩略图类型  值为small,mid,max
 * @return string
 */
function groupbuy_thumb($image_name = '')
{
    if (empty($image_name)) {
        return UPLOAD_SITE_URL . '/' . default_goodsimage('normal');
    }
    list($base_name, $ext) = explode('.', $image_name);
    list($store_id) = explode('_', $base_name);
    $file_path = ATTACH_GROUPBUY . DS . $store_id . DS . $image_name;
    if (!file_exists(BASE_UPLOAD_PATH . DS . $file_path)) {
        return UPLOAD_SITE_URL . '/' . default_goodsimage('normal');
    }
    return UPLOAD_SITE_URL . '/' . $file_path;
}

/**
 * 取得买家缩略图的完整URL路径
 *
 * @param string $imgurl 商品名称
 * @param string $type 缩略图类型  值为240,1024
 * @return string
 */
function sns_thumb($image_name = '', $type = '')
{
    if (!in_array($type, array('240', '1024')))
        $type = '240';
    if (empty($image_name)) {
        return UPLOAD_SITE_URL . '/' . default_goodsimage('normal');
    }

    list($member_id) = explode('_', $image_name);
    $file_path = ATTACH_MALBUM . DS . $member_id . DS . $image_name;
    if (!file_exists(BASE_UPLOAD_PATH . '/' . $file_path)) {
        return UPLOAD_SITE_URL . '/' . default_goodsimage('normal');
    }
    return UPLOAD_SITE_URL . '/' . $file_path;
}

/**
 * 取得买家缩略图的完整URL路径
 *
 * @param string $imgurl 商品名称
 * @param string $type 缩略图类型  值为240,1024
 * @return string
 */
function flea_thumb($image_name = '', $type = '')
{
    if (!in_array($type, array('240', '1024')))
        $type = '240';
    if (empty($image_name)) {
        return UPLOAD_SITE_URL . '/' . default_goodsimage('normal');
    }

    list($member_id) = explode('_', $image_name);
    $file_path = ATTACH_MFLEA . '/' . $member_id . '/' . $image_name;
    if (!file_exists(BASE_UPLOAD_PATH . '/' . $file_path)) {
        return UPLOAD_SITE_URL . '/' . default_goodsimage('normal');
    }
    return UPLOAD_SITE_URL . '/' . $file_path;
}

/**
 * 取得积分商品缩略图的完整URL路径
 *
 * @param string $imgurl 商品名称
 * @param string $type 缩略图类型  值为small
 * @return string
 */
function pointprod_thumb($image_name = '', $type = '')
{

    if (empty($image_name)) {
        return UPLOAD_SITE_URL . '/' . default_goodsimage('normal');
    }
    $file_path = ATTACH_POINTPROD . DS . $image_name;

    if (!file_exists(BASE_UPLOAD_PATH . DS . $file_path)) {
        return UPLOAD_SITE_URL . '/' . default_goodsimage('normal');
    }
    return UPLOAD_SITE_URL . '/' . $file_path;
}

/**
 * 取得品牌图片
 *
 * @param string $image_name
 * @return string
 */
function brand_image($image_name = '')
{
    if ($image_name != '') {
        return UPLOAD_SITE_URL . '/' . ATTACH_BRAND . '/' . $image_name;
    }
    return UPLOAD_SITE_URL . '/' . ATTACH_COMMON . '/default_brand_image.gif';
}

/**
 * 取得订单状态文字输出形式
 *
 * @param array $order_info 订单数组
 * @return string $order_state 描述输出
 */
function get_order_state($order_info)
{
    switch ($order_info['order_state']) {
        case ORDER_STATE_CANCEL:
            $order_state = lang('order_state_cancel');
            break;
        case ORDER_STATE_NEW:
            $order_state = lang('order_state_new');
            break;
        case ORDER_STATE_PAY:
            $order_state = lang('order_state_pay');
            break;
        case ORDER_STATE_SEND:
            $order_state = lang('order_state_send');
            break;
        case ORDER_STATE_SUCCESS:
            $order_state = lang('order_state_success');
            break;
    }
    return $order_state;
}

/**
 * 取得订单支付类型文字输出形式
 *
 * @param array $payment_code
 * @return string
 */
function get_order_payment_name($payment_code)
{
    return str_replace(array('offline', 'online', 'alipay', 'alipay_h5', 'alipay_app', 'wxpay_native', 'wxpay_jsapi', 'wxpay_h5', 'wxpay_app', 'predeposit'), array('货到付款', '在线付款', '支付宝PC支付', '支付宝手机支付', '支付宝APP支付', '微信扫码支付', '微信公众号支付', '微信H5支付', '微信APP支付', '站内余额支付'), $payment_code);
}

/**
 * 取得订单商品销售类型文字输出形式
 *
 * @param array $goods_type
 * @return string 描述输出
 */
function get_order_goodstype($goods_type)
{
    return str_replace(array('1', '2', '3', '4', '5','6','7'), array('', '抢购', '限时折扣', '优惠套装', '赠品','拼团','会员折扣'), $goods_type);
}

/**
 * 取得结算文字输出形式
 *
 * @param array $bill_state
 * @return string 描述输出
 */
function get_bill_state($bill_state)
{
    return str_replace(array('1', '2', '3', '4'), array('已出账', '商家已确认', '平台已审核', '结算完成'), $bill_state);
}

/**
 * 取得广告图片
 *
 * @param string $image_name
 * @return string
 */
function adv_image($image_name = '')
{
    if ($image_name != '') {
        return UPLOAD_SITE_URL . '/' . ATTACH_ADV . '/' . $image_name;
    }
}

?>
