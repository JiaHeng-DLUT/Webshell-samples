<?php

/*
 * 多级选择：地区选择，分类选择
 */

namespace app\home\controller;

use think\Lang;

class Mlselection extends BaseHome {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/mlselection.lang.php');
    }

    function index() {
        $type = input('param.type');
        $pid = intval(input('param.pid'));
        $result=array();
        in_array($type, array('region', 'goodsclass')) or json_encode('invalid type');
        switch ($type) {
            case 'region':
                $area_mod=model('area');
                $regions = $area_mod->getAreaList(array('area_parent_id'=>$pid));
                foreach ($regions as $key => $region) {
                    $result[$key]['area_name'] = htmlspecialchars($region['area_name']);
                    $result[$key]['area_id'] = $region['area_id'];
                }
                ds_json_encode(10000,'',$result);
                break;
            case 'goodsclass':
                $goodsclass_model = model('goodsclass');
                $goods_class = $goodsclass_model->getGoodsclassListByParentId($pid);
                $array = array();
                if (is_array($goods_class) and count($goods_class) > 0) {
                    foreach ($goods_class as $val) {
                        $array[$val['gc_id']] = array('gc_id' => $val['gc_id'], 'gc_name' => htmlspecialchars($val['gc_name']), 'gc_parent_id' => $val['gc_parent_id'], 'commis_rate' => $val['commis_rate'], 'gc_sort' => $val['gc_sort']);
                    }
                }
                ds_json_encode(10000,'',array_values($array));
                break;
        }
    }

}

?>
