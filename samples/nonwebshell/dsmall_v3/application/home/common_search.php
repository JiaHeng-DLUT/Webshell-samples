<?php

/**
 * 删除地址参数
 *
 * @param array $param
 */
function dropParam($param) {
    $purl = getParam();
    if (!empty($param)) {
        foreach ($param as $val) {
            $purl['param'][$val] = 0;
        }
    }
    return url(request()->module().'/'.request()->controller().'/'.request()->action(),$purl['param']);
}

/**
 * 替换地址参数
 *
 * @param array $param
 */
function replaceParam($param) {
    $purl = getParam();
    if (!empty($param)) {
        foreach ($param as $key => $val) {
            $purl['param'][$key] = $val;
        }
    }

    return url(request()->module().'/'.request()->controller().'/'.request()->action(),$purl['param']);
}

/**
 * 替换并删除地址参数
 *
 * @param array $param
 */
function replaceAndDropParam($paramToReplace, $paramToDrop) {
    $purl = getParam();
    if (!empty($paramToReplace)) {
        foreach ($paramToReplace as $key => $val) {
            $purl['param'][$key] = $val;
        }
    }
    if (!empty($paramToDrop)) {
        foreach ($paramToDrop as $val) {
            $purl['param'][$val] = 0;
        }
    }

    return url(request()->module().'/'.request()->controller().'/'.request()->action(),$purl['param']);
}

/**
 * 删除部分地址参数
 *
 * @param array $param
 */
function removeParam($param) {
    $purl = getParam();
    if (!empty($param)) {
        foreach ($param as $key => $val) {
            if (!isset($purl['param'][$key])) {
                continue;
            }
            $tpl_params = explode('_', $purl['param'][$key]);
            foreach ($tpl_params as $k => $v) {
                if ($val == $v) {
                    unset($tpl_params[$k]);
                }
            }
            if (empty($tpl_params)) {
                $purl['param'][$key] = 0;
            } else {
                $purl['param'][$key] = implode('_', $tpl_params);
            }
        }
    }
    return url(request()->module().'/'.request()->controller().'/'.request()->action(),$purl['param']);
}

function getParam() {
    $param = input('param.');
    $purl = array();
    unset($param['page']);
    $param=str_replace('/','+',$param);
    $purl['param'] = $param;
    return $purl;
}

?>
