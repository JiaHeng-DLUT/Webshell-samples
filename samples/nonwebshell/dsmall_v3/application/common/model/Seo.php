<?php

namespace app\common\model;

use think\Model;

class Seo extends Model {

    /**
     * 存放SEO信息
     * @access private
     * @author csdeshang
     * @var obj
     */
    private $seo;

    /**
     * 取得SEO信息
     * @access public
     * @author csdeshang
     * @param array/string $type 类型
     * @return obj
     */
    public function type($type) {
        if (is_array($type)) { //商品分类
            $this->seo['seo_title'] = isset($type[1])?$type[1]:'';
            $this->seo['seo_keywords'] = isset($type[2])?$type[2]:'';
            $this->seo['seo_description'] = isset($type[3])?$type[3]:'';
        } else {
            $this->seo = $this->getSeo($type);
        }
        if (!is_array($this->seo))
            return $this;
        foreach ($this->seo as $key => $value) {
            $this->seo[$key] = str_replace(array('{sitename}'), array(config('site_name')), $value);
        }
        return $this;
    }

    /**
     * 生成SEO缓存并返回
     * @access private
     * @author csdeshang
     * @param string $type 类型
     * @return array
     */
    private function getSeo($type) {
        $list = rkcache('seo', true);
        return $list[$type];
    }

    /**
     * 传入参数替换SEO中的标签
     * @access public
     * @author csdeshang
     * @param array $array 参数数组
     * @return obj
     */
    public function param($array = null) {
        if (!is_array($this->seo))
            return $this;
        if (is_array($array)) {
            $array_key = array_keys($array);
            foreach ($array_key as $k=>$val){
                $array_key[$k]='{'.$val.'}';
            }
            foreach ($this->seo as $key => $value) {
                $this->seo[$key] = str_replace($array_key, array_values($array), $value);
            }
        }
        return $this;
    }

    /**
     * 抛出SEO信息到模板
     * @access public
     * @author csdeshang
     * @return type
     */
    public function show() {
        $this->seo['seo_title'] = preg_replace("/{.*}/siU", '', $this->seo['seo_title']);
        $this->seo['seo_keywords'] = preg_replace("/{.*}/siU", '', $this->seo['seo_keywords']);
        $this->seo['seo_description'] = preg_replace("/{.*}/siU", '', $this->seo['seo_description']);
        return array(
            'html_title' => $this->seo['seo_title'] ? $this->seo['seo_title'] : config('site_name'),
            'seo_keywords' => $this->seo['seo_keywords'] ? $this->seo['seo_keywords'] : config('site_name'),
            'seo_description' => $this->seo['seo_description'] ? $this->seo['seo_description'] : config('site_name'),
        );
    }
}

?>
