<?php

namespace app\crontab\controller;

class Hour extends BaseCron {
    
    /**
     * 执行频率常量 1小时
     * @var int
     */
    const EXE_TIMES = 3600;

    private $_doc;
    private $_xs;
    private $_index;
    private $_search;

    /**
     * 默认方法
     */
    public function index() {
        //更新全文搜索内容
        $this->_xs_update();
    }

    /**
     * 初始化对象
     */
    private function _ini_xs(){
        import('xs.lib.XS', EXTEND_PATH);
        $this->_doc = new \XSDocument();
        $this->_xs = new \XS('ds');
        $this->_index = $this->_xs->index;
        $this->_search = $this->_xs->search;
        $this->_search->setCharset(CHARSET);
    }

    /**
     * 全量创建索引
     */
    public function xs_create() {
        if (!config('fullindexer.open')) return;
        $this->_ini_xs();

        try {
            //每次批量更新商品数
            $step_num = 200;
            $goods_model = model('goods');
            $count = db('goods')->where(array('goods_state'=>1))->field("distinct CONCAT(goods_commonid,',',color_id)")->count();
            echo 'Total:'.$count."\n";
            $fields = "*,CONCAT(goods_commonid,',',color_id) as nc_distinct";
            for ($i = 0; $i <= $count; $i = $i + $step_num){
                $goods_list = $goods_model->getGoodsOnlineList(array(), $fields, 0, '', "{$i},{$step_num}", 'nc_distinct');
                $this->_build_goods($goods_list);
                echo $i." ok\n";
                flush();
                ob_flush();
            }
            if ($count > 0) {
                sleep(2);
                $this->_index->flushIndex();
                sleep(2);
                $this->_index->flushLogging();
            }
        } catch (XSException $e) {
            $this->log($e->getMessage());
        }
    }

    /**
     * 更新增量索引
     */
    public function _xs_update() {
        if (!config('fullindexer.open')) return;
        $this->_ini_xs();

        try {
            //更新多长时间内的新增(编辑)商品信息，该时间一般与定时任务触发间隔时间一致,单位是秒,默认3600
            $step_time = self::EXE_TIMES + 60;
            //每次批量更新商品数
            $step_num = 100;

            $goods_model = model('goods');
            $condition = array();
            $condition['goods_edittime'] = array('egt',TIMESTAMP-$step_time);
            $count = db('goods')->where(array('goods_state'=>1))->where($condition)->field("distinct CONCAT(goods_commonid,color_id)")->count();
            $fields = "*,CONCAT(goods_commonid,color_id) as nc_distinct";
            for ($i = 0; $i <= $count; $i = $i + $step_num){
                $goods_list = $goods_model->getGoodsOnlineList($condition, $fields, 0, '', "{$i},{$step_num}", 'nc_distinct');
                $this->_build_goods($goods_list);
            }
            if ($count > 0) {
                sleep(2);
                $this->_index->flushIndex();
                sleep(2);
                $this->_index->flushLogging();
            }
        } catch (XSException $e) {
            $this->log($e->getMessage());
        }
    }

    /**
     * 索引商品数据
     * @param array $goods_list
     */
    private function _build_goods($goods_list = array()) {
        if (empty($goods_list) || !is_array($goods_list)) return;
        $goods_class = model('goodsclass')->getGoodsclassForCacheModel();

        $goods_commonid_array = array();
        $goods_id_array = array();
        $store_id_array = array();
        foreach ($goods_list as $k => $v) {
            $goods_commonid_array[] = $v['goods_commonid'];
            $goods_id_array[] = $v['goods_id'];
            $store_id_array[] = $v['store_id'];
        }

        //取common表内容
        $goods_model = model('goods');
        $condition_common = array();
        $condition_common['goods_commonid'] = array('in',$goods_commonid_array);
        $goods_common_list = $goods_model->getGoodsCommonOnlineList($condition_common,'*',0);
        $goods_common_new_list = array();
        foreach($goods_common_list as $k => $v) {
            $goods_common_new_list[$v['goods_commonid']] = $v;
        }

        //取属性表值
        $attr_list = model('goodsattrindex')->getGoodsAttrIndexList(array('goods_id'=>array('in',$goods_id_array)),'goods_id,attrvalue_id');
        if (is_array($attr_list) && !empty($attr_list)) {
            $attr_value_list = array();
            foreach ($attr_list as $val) {
                $attr_value_list[$val['goods_id']][] = $val['attrvalue_id'];
            }
        }
        //整理需要索引的数据
        foreach ($goods_list as $k => $v) {
            $gc_id = $v['gc_id'];
            $depth = $goods_class[$gc_id]['depth'];
            if ($depth == 3) {
                $cate_3 = $gc_id; $gc_id = $goods_class[$gc_id]['gc_parent_id']; $depth--;
            }
            if ($depth == 2) {
                $cate_2 = $gc_id; $gc_id = $goods_class[$gc_id]['gc_parent_id']; $depth--;
            }
            if ($depth == 1) {
                $cate_1 = $gc_id; $gc_id = $goods_class[$gc_id]['gc_parent_id'];
            }
            $index_data = array();
            $index_data['pk'] = $v['goods_id'];
            $index_data['goods_id'] = $v['goods_id'];
            $index_data['goods_name'] = $v['goods_name'].$v['goods_advword'];
            $index_data['brand_id'] = $v['brand_id'];
            $index_data['goods_price'] = $v['goods_promotion_price'];
            $index_data['goods_click'] = $v['goods_click'];
            $index_data['goods_salenum'] = $v['goods_salenum'];
            // 判断店铺是否为自营店铺
            $index_data['store_id'] = $v['is_platform_store'];
            $index_data['area_id'] = $v['areaid_1'];
            $index_data['gc_id'] = $v['gc_id'];
            $index_data['gc_name'] = str_replace('&gt;','',$goods_common_new_list[$v['goods_commonid']]['gc_name']);
            $index_data['brand_name'] = $goods_common_new_list[$v['goods_commonid']]['brand_name'];
            $index_data['is_have_gift'] = $v['is_have_gift'];
            if (!empty($attr_value_list[$v['goods_id']])) {
                $index_data['attr_id'] = implode('_',$attr_value_list[$v['goods_id']]);
            }
            if (!empty($cate_1)) {
                $index_data['cate_1'] = $cate_1;
            }
            if (!empty($cate_2)) {
                $index_data['cate_2'] = $cate_2;
            }
            if (!empty($cate_3)) {
                $index_data['cate_3'] = $cate_3;
            }
            //添加到索引库
            $this->_doc->setFields($index_data);
            $this->_index->update($this->_doc);
        }
    }

    public function xs_clear(){
        if (!config('fullindexer.open')) return;
        $this->_ini_xs();

        try {
            $this->_index->clean();
        } catch (XSException $e) {
            $this->log($e->getMessage());
        }
    }

    public function xs_flushLogging(){
        if (!config('fullindexer.open')) return;
        $this->_ini_xs();
        try {
            $this->_index->flushLogging();
        } catch (XSException $e) {
            $this->log($e->getMessage());
        }
    }

    public function xs_flushIndex(){
        if (!config('fullindexer.open')) return;
        $this->_ini_xs();
    
        try {
            $this->_index->flushIndex();
        } catch (XSException $e) {
            $this->log($e->getMessage());
        }
    }
    
    
}
?>
