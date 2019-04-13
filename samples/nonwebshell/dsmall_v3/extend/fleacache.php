<?php
use think\Cache;
final class fleacache {
	
    public static function getCache($type, $param = "") {

        $type = strtoupper($type[0]) . strtolower(substr($type, 1));
        $function = "get" . $type . "Cache";
        try {
            do {
                if (method_exists(fleacache, $function)) {
                    break;
                } else {
                    $error = lang('please_check_your_cache_type');
                    throw new Exception($error);
                }
            } while (0);
        }
        catch(Exception $e) {

        }
        $result = self::$function($param);
        return $result;
    }
	
    private static function getFlea_areaCache($param) {
        $deep = $param['deep'];
        if (Cache::has("flea_area_" . $deep) && empty($param['new'])) {
            eval(Cache::get("flea_area_" . $deep));
            return $data;
        }
        $condition = array();
        $condition['fleaarea_deep'] = $deep;
        $order = "fleaarea_sort asc";
        $result =  model('fleaarea')->getFleaareaList($condition,'*',$order);
        $tmp= "";
        $tmp.= "\$data = array(\r\n";
        if (is_array($result)) {
            foreach ($result as $k => $v) {
                $tmp.= "\tarray(\r\n";
                $tmp.= "\t\t'fleaarea_id'=>'" . $v['fleaarea_id'] . "',\r\n";
                $tmp.= "\t\t'fleaarea_name'=>'" . htmlspecialchars($v['fleaarea_name']) . "',\r\n";
                $tmp.= "\t\t'fleaarea_parent_id'=>'" . $v['fleaarea_parent_id'] . "',\r\n";
                $tmp.= "\t\t'fleaarea_sort'=>'" . $v['fleaarea_sort'] . "',\r\n";
                $tmp.= "\t\t'fleaarea_deep'=>'" . $v['fleaarea_deep'] . "',\r\n";
                $tmp.= "\t),\r\n";
            }
        }
        $tmp.= ");";
        try {
            if (Cache::set("flea_area_" . $deep,$tmp,3600) === FALSE) {
                $error = lang('please_check_your_system_chmod_area');
                throw new Exception();
            }
            eval(Cache::get("flea_area_" . $deep));
            return $data;
        }
        catch(Exception $e) {

        }
    }
	
}
?>