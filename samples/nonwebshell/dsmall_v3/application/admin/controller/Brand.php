<?php

namespace app\admin\controller;

use think\Lang;

class Brand extends AdminControl {

    const EXPORT_SIZE = 1000;

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/brand.lang.php');
    }

    /**
     * 品牌列表
     */
    public function index() {
        $brand_model = model('brand');
        /**
         * 检索条件
         */
        if (!empty(input('param.search_brand_name'))) {
            $condition['brand_name'] = array('like', "%" . input('param.search_brand_name') . "%");
        }
        if (!empty(input('param.search_brand_class'))) {
            $condition['brand_class'] = array('like', "%" . input('param.search_brand_class') . "%");
        }
        $condition['brand_apply'] = '1';
        $brand_list = $brand_model->getBrandList($condition, "*", 10);
        $this->assign('showpage', $brand_model->page_info->render());
        $this->assign('brand_list', $brand_list);
        $this->assign('search_brand_name', trim(input('param.search_brand_name')));
        $this->assign('search_brand_class', trim(input('param.search_brand_class')));
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     * 增加品牌
     */
    public function brand_add() {

        $brand_model = model('brand');
        if (request()->isPost()) {
            $data = [
                'brand_name' => input('post.brand_name'), 'brand_initial' => input('post.brand_initial'),
                'brand_sort' => input('post.brand_sort')
            ];
            $brand_validate = validate('brand');

            if (!$brand_validate->scene('brand_add')->check($data)) {
                $this->error($brand_validate->getError());
            } else {
                $insert_array = array();
				if (!empty($_FILES['_pic']['name'])) {
                    $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_BRAND;
                    $file = request()->file('_pic');
                    $result = $file->rule('uniqid')->validate(['ext' => 'jpg,png,gif'])->move($upload_file);
                    if ($result) {
                        $brand_pic = $result->getFilename();
                    }
                }
                $insert_array['brand_name'] = trim(input('post.brand_name'));
                $insert_array['brand_initial'] = strtoupper(input('post.brand_initial'));
                $insert_array['gc_id'] = input('post.class_id');
                $insert_array['brand_class'] = trim(input('post.brand_class'));
                if (!empty($brand_pic)) {
                    $insert_array['brand_pic'] = $brand_pic;
                }
                $insert_array['brand_recommend'] = trim(input('post.brand_recommend'));
                $insert_array['brand_sort'] = intval(input('post.brand_sort'));
                $insert_array['brand_showtype'] = intval(input('post.brand_showtype')) == 1 ? 1 : 0;
                $result = $brand_model->addBrand($insert_array);
                if ($result) {
                    $this->log(lang('ds_add') . lang('brand_index_brand') . '[' . input('post.brand_name') . ']', 1);
                    dsLayerOpenSuccess(lang('ds_common_save_succ'));
                } else {
                    $this->error(lang('ds_common_save_fail'));
                }
            }
        } else {
            $brand_array = [
                'brand_id' => '',
                'brand_name' => '',
                'brand_initial' => '',
                'gc_id' => '',
                'brand_class' => '',
                'brand_pic' => '',
                'brand_showtype' => '0',
                'brand_recommend' => '1',
                'brand_sort' => '0',
            ];
            $this->assign('brand_array', $brand_array);

            // 一级商品分类
            $gc_list = model('goodsclass')->getGoodsclassListByParentId(0);
            $this->assign('gc_list', $gc_list);
            return $this->fetch('form');
        }
    }

    /**
     * 品牌编辑
     */
    public function brand_edit() {
        $brand_model = model('brand');

        if (request()->isPost()) {
            $data = [
                'brand_name' => input('post.brand_name'), 'brand_initial' => input('post.brand_initial'),
                'brand_sort' => input('post.brand_sort')
            ];
            $brand_validate = validate('brand');
            if (!$brand_validate->scene('brand_edit')->check($data)) {
                $this->error($brand_validate->getError());
            } else {
                if (!empty($_FILES['_pic']['name'])) {
                    $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_BRAND;
                    $file = request()->file('_pic');
                    $result = $file->rule('uniqid')->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
                    if ($result) {
                        $brand_pic = $result->getFilename();
                    }
                }
                $brand_info = $brand_model->getBrandInfo(array('brand_id' => intval(input('post.brand_id'))));
                $where = array();
                $where['brand_id'] = intval(input('post.brand_id'));
                $update_array = array();
                $update_array['brand_name'] = trim(input('post.brand_name'));
                $update_array['brand_initial'] = strtoupper(input('post.brand_initial'));
                $update_array['gc_id'] = input('post.class_id');
                $update_array['brand_class'] = trim(input('post.brand_class'));
                if (!empty($brand_pic)) {
                    $update_array['brand_pic'] = $brand_pic;
                }
                $update_array['brand_recommend'] = intval(input('post.brand_recommend'));
                $update_array['brand_sort'] = intval(input('post.brand_sort'));
                $update_array['brand_showtype'] = intval(input('post.brand_showtype')) == 1 ? 1 : 0;
                $result = $brand_model->editBrand($where, $update_array);
                if ($result>=0) {
                    if (!empty(input('post.brand_pic')) && !empty($brand_info['brand_pic'])) {
                        @unlink(BASE_UPLOAD_PATH . DS . ATTACH_BRAND . DS . $brand_info['brand_pic']);
                    }
                    $this->log(lang('ds_edit') . lang('brand_index_brand') . '[' . input('post.brand_name') . ']', 1);
                    dsLayerOpenSuccess(lang('ds_common_save_succ'));
                } else {
                    $this->log(lang('ds_edit') . lang('brand_index_brand') . '[' . input('post.brand_name') . ']', 0);
                    $this->error(lang('ds_common_save_fail'));
                }
            }
        } else {
            $brand_info = $brand_model->getBrandInfo(array('brand_id' => intval(input('param.brand_id'))));
            if (empty($brand_info)) {
                $this->error(lang('param_error'));
            }
            $this->assign('brand_array', $brand_info);
            // 一级商品分类
            $gc_list = model('goodsclass')->getGoodsclassListByParentId(0);
            $this->assign('gc_list', $gc_list);
            return $this->fetch('form');
        }
    }

    /**
     * 删除品牌
     */
    public function brand_del() {
        $brand_id = input('param.brand_id');
        $brand_id_array = ds_delete_param($brand_id);
        if ($brand_id_array == FALSE) {
            $this->log(lang('ds_del') . lang('brand_index_brand') . '[ID:' . $brand_id . ']', 0);
            ds_json_encode(10001, lang('param_error'));
        }
        $brand_mod = model('brand');
        $brand_mod->delBrand(array('brand_id' => array('in', implode(',', $brand_id_array))));
        $this->log(lang('ds_del') . lang('brand_index_brand') . '[ID:' . $brand_id . ']', 1);
        ds_json_encode(10000, lang('ds_common_del_succ'));
    }

    /**
     * 品牌申请
     */
    public function brand_apply() {
        $brand_model = model('brand');
        /**
         * 对申请品牌进行操作 通过，拒绝
         */
        if (request()->isPost()) {
            $del_id_array = input('post.del_id/a');#获取数组
            if (!empty($del_id_array)) {
                switch (input('post.type')) {
                    case 'pass':
                        //更新品牌 申请状态
                        $brandid_array = array();
                        foreach ($del_id_array as $v) {
                            $brandid_array[] = intval($v);
                        }
                        $update_array = array();
                        $update_array['brand_apply'] = 1;
                        $brand_model->editBrand(array('brand_id' => array('in', $brandid_array)), $update_array);
                        $this->log(lang('brand_apply_pass') . '[ID:' . implode(',', $brandid_array) . ']', null);
                        $this->success(lang('brand_apply_passed'));
                        break;
                    case 'refuse':
                        //删除该品牌
                        $brandid_array = array();
                        foreach ($del_id_array as $v) {
                            $brandid_array[] = intval($v);
                        }
                        $brand_model->delBrand(array('brand_id' => array('in', $brandid_array)));
                        $this->log(lang('ds_del') . lang('brand_index_brand') . '[ID:' . implode(',', $del_id_array) . ']', 1);
                        $this->success(lang('ds_common_del_succ'));
                        break;
                    default:
                        $this->success(lang('brand_apply_invalid_argument'));
                }
            } else {
                $this->log(lang('ds_del') . lang('brand_index_brand'), 0);
                $this->error(lang('ds_common_del_fail'));
            }
        } else {
            /**
             * 检索条件
             */
            $condition = array();
            if (!empty(input('param.search_brand_name'))) {
                $condition['brand_name'] = array('like', '%' . trim(input('param.search_brand_name')) . '%');
            }
            if (!empty(input('param.search_brand_class'))) {
                $condition['brand_class'] = array('like', '%' . trim(input('param.search_brand_class')) . '%');
            }
            $brand_list = $brand_model->getBrandNoPassedList($condition, '*', 10);

            $this->assign('brand_list', $brand_list);
            $this->assign('show_page', $brand_model->page_info->render());
            $this->assign('search_brand_name', trim(input('param.search_brand_name')));
            $this->assign('search_brand_class', trim(input('param.search_brand_class')));
            $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件
            $this->setAdminCurItem('brand_apply');
            return $this->fetch('brand_apply');
        }
    }

    /**
     * 审核 申请品牌操作
     */
    public function brand_apply_set() {
        $brand_model = model('brand');

        if (intval(input('param.brand_id')) > 0) {
            switch (input('param.state')) {
                case 'pass':
                    /**
                     * 更新品牌 申请状态
                     */
                    $update_array = array();
                    $update_array['brand_apply'] = 1;
                    $result = $brand_model->editBrand(array('brand_id' => intval(input('param.brand_id'))), $update_array);
                    if ($result) {
                        $this->log(lang('brand_apply_pass') . '[ID:' . intval(input('param.brand_id')) . ']', null);
                        $this->success(lang('brand_apply_pass'));
                    } else {
                        $this->log(lang('brand_apply_fail') . '[ID:' . intval(input('param.brand_id')) . ')', 0);
                        $this->error(lang('brand_apply_fail'));
                    }
                    break;
                case 'refuse':
                    // 删除
                    $brand_model->delBrand(array('brand_id' => intval(input('param.brand_id'))));
                    $this->log(lang('ds_del') . lang('brand_index_brand') . '[ID:' . intval(input('param.brand_id')) . ']', 1);
                    $this->success(lang('ds_common_del_succ'));
                    break;
                default:
                    $this->error(lang('brand_apply_paramerror'));
            }
        } else {
            $this->log(lang('ds_del') . lang('brand_index_brand') . '[ID:' . intval(input('param.brand_id')) . ']', 0);
            $this->error(lang('brand_apply_brandparamerror'));
        }
    }

    /**
     * ajax操作
     */
    public function ajax() {
        $brand_model = model('brand');
        switch (input('param.branch')) {
            /**
             * 品牌名称
             */
            case 'brand_name':
                /**
                 * 判断是否有重复
                 */
                $condition['brand_name'] = trim(input('param.value'));
                $condition['brand_id'] = array('neq', intval(input('param.id')));
                $result = $brand_model->getBrandList($condition);
                if (empty($result)) {
                    $brand_model->editBrand(array('brand_id' => intval(input('param.id'))), array('brand_name' => trim(input('param.value'))));
                    $this->log(lang('ds_edit') . lang('brand_index_name') . '[' . input('param.value') . ']', 1);
                    echo 'true';
                    exit;
                } else {
                    echo 'false';
                    exit;
                }
                break;
            /**
             * 品牌类别，品牌排序，推荐
             */
            case 'brand_class':
            case 'brand_sort':
            case 'brand_recommend':
                $brand_model->editBrand(array('brand_id' => intval(input('param.id'))), array(input('param.column') => trim(input('param.value'))));
                $detail_log = str_replace(array(
                    'brand_class', 'brand_sort', 'brand_recommend'
                        ), array(
                    lang('brand_index_class'), lang('ds_sort'), lang('ds_recommend')
                        ), input('param.branch'));
                $this->log(lang('ds_edit') . lang('brand_index_brand') . $detail_log . '[ID:' . intval(input('param.id')) . ')', 1);
                echo 'true';
                exit;
                break;
            /**
             * 验证品牌名称是否有重复
             */
            case 'check_brand_name':
                $condition['brand_name'] = trim(input('param.brand_name'));
                $condition['brand_id'] = array('neq', intval(input('param.id')));
                $result = $brand_model->getBrandList($condition);
                if (empty($result)) {
                    echo 'true';
                    exit;
                } else {
                    echo 'false';
                    exit;
                }
                break;
        }
    }

    /**
     * 品牌导出第一步
     */
    public function export_step1() {
        $brand_model = model('brand');
        $condition = array();
        if ((input('param.search_brand_name'))) {
            $condition['brand_name'] = array('like', "%{input('param.search_brand_name')}%");
        }
        if ((input('param.search_brand_class'))) {
            $condition['brand_class'] = array('like', "%{input('param.search_brand_class')}%");
        }
        $condition['brand_apply'] = '1';

        if (!is_numeric(input('param.page'))) {
            $count = $brand_model->getBrandCount($condition);
            $export_list = array();
            if ($count > self::EXPORT_SIZE) {    //显示下载链接
                $page = ceil($count / self::EXPORT_SIZE);
                for ($i = 1; $i <= $page; $i++) {
                    $limit1 = ($i - 1) * self::EXPORT_SIZE + 1;
                    $limit2 = $i * self::EXPORT_SIZE > $count ? $count : $i * self::EXPORT_SIZE;
                    $export_list[$i] = $limit1 . ' ~ ' . $limit2;
                }
                $this->assign('export_list', $export_list);
                return $this->fetch('export_excel');
            } else {    //如果数量小，直接下载
                $data = $brand_model->getBrandList($condition, '*', self::EXPORT_SIZE, 'brand_id desc');
                $this->createExcel($data);
            }
        } else {    //下载
            $limit1 = (input('param.curpage') - 1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $data = $brand_model->getBrandList($condition, '*', $limit2, 'brand_id desc', "{$limit1},{$limit2}");
            $this->createExcel($data);
        }
    }

    /**
     * 生成excel
     *
     * @param array $data
     */
    private function createExcel($data = array()) {
        Lang::load(APP_PATH .'admin/lang/'.config('default_lang').'/export.lang.php');
        $excel_obj = new \excel\Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array(
            'id' => 's_title', 'Font' => array('FontName' => lang('ds_song_typeface'), 'Size' => '12', 'Bold' => '1')
        ));
        //header
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_brandid'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_brand'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_brand_cate'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_brand_img'));
        foreach ((array) $data as $k => $v) {
            $tmp = array();
            $tmp[] = array('data' => $v['brand_id']);
            $tmp[] = array('data' => $v['brand_name']);
            $tmp[] = array('data' => $v['brand_class']);
            $tmp[] = array('data' => $v['brand_pic']);
            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data, CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset(lang('exp_brand'), CHARSET));
        $excel_obj->generateXML($excel_obj->charset(lang('exp_brand'), CHARSET) . input('param.curpage') . '-' . date('Y-m-d-H', time()));
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index', 
                'text' => lang('ds_manage'),
                'url' => url('Brand/index'),
            ),
            array(
                'name' => 'brand_add',
                'text' => lang('ds_add'), 
                'url' => "javascript:dsLayerOpen('".url('Brand/brand_add')."','添加')"
            ),
            array(
                'name' => 'brand_apply', 
                'text' => lang('brand_index_to_audit'),
                'url' => url('Brand/brand_apply')
            )
        );
        return $menu_array;
    }

}