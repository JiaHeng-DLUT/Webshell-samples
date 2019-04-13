<?php

namespace app\admin\controller;

use think\Lang;

class Article extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/article.lang.php');
    }

    public function index() {

        /**
         * 检索条件
         */
        $condition = array();
        $search_ac_id = intval(input('param.search_ac_id'));
        if ($search_ac_id) {
            $condition['ac_id'] = $search_ac_id;
        }
        $search_title = trim(input('param.search_title'));
        if ($search_title) {
            $condition['article_title'] = array('like', "%" . $search_title . "%");
        }
        $article_model = model('article');
        $article_list = $article_model->getArticleList($condition, 10);

        $articleclass_model = model('articleclass');
        /**
         * 整理列表内容
         */
        if (is_array($article_list)) {
            /**
             * 取文章分类
             */
            $class_list = $articleclass_model->getArticleclassList(array());
            $tmp_class_name = array();
            if (is_array($class_list)) {
                foreach ($class_list as $k => $v) {
                    $tmp_class_name[$v['ac_id']] = $v['ac_name'];
                }
            }
            foreach ($article_list as $k => $v) {
                /**
                 * 发布时间
                 */
                $article_list[$k]['article_time'] = date('Y-m-d H:i:s', $v['article_time']);
                /**
                 * 所属分类
                 */
                if (@array_key_exists($v['ac_id'], $tmp_class_name)) {
                    $article_list[$k]['ac_name'] = $tmp_class_name[$v['ac_id']];
                }
            }
        }

        /**
         * 分类列表
         */
        $parent_list = $articleclass_model->getTreeClassList(2);
        if (is_array($parent_list)) {
            $unset_sign = false;
            foreach ($parent_list as $k => $v) {
                $parent_list[$k]['ac_name'] = str_repeat("&nbsp;", $v['deep'] * 2) . $v['ac_name'];
            }
        }

        $this->assign('article_list', $article_list);
        $this->assign('show_page', $article_model->page_info->render());
        $this->assign('search_title', $search_title);
        $this->assign('search_ac_id', $search_ac_id);
        $this->assign('parent_list', $parent_list);
        
        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件
        
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    public function add() {
        if (!(request()->isPost())) {
            $article = [
                'article_id' => 0,
                'article_title' => '',
                'ac_id' => input('param.ac_id'),
                'article_url' => '',
                'article_show' => 0,
                'article_sort' => 0,
                'article_content' => '',
            ];
            $articleclass_model = model('articleclass');
            $cate_list=$articleclass_model->getTreeClassList(2);
            $this->assign('ac_list', $cate_list);
            $this->assign('article', $article);
            //游离图片
            $article_pic_list=model('upload')->getUploadList(array('upload_type'=>'1','item_id'=>0));
            $this->assign('file_upload', $article_pic_list);
            $this->setAdminCurItem('add');
            return $this->fetch('form');
        } else {
            $data = array(
                'article_title' => input('post.article_title'),
                'ac_id' => input('post.ac_id'),
                'article_url' => input('post.article_url'),
                'article_sort' => input('post.article_sort'),
                'article_content' => input('post.article_content'),
                'article_time' => TIMESTAMP,
            );
            $data['article_show'] = intval(input('post.article_show'));

            $article_validate = validate('article');
            if (!$article_validate->scene('add')->check($data)) {
                $this->error($article_validate->getError());
            }

            $article_id = model('article')->addArticle($data);
            if ($article_id) {
                //更新图片信息ID
                $upload_model = model('upload');
                $file_id_array = input('post.file_id/a');
                if (is_array($file_id_array)) {
                    foreach ($file_id_array as $k => $v) {
                        $update_array = array();
                        $update_array['upload_id'] = intval($v);
                        $update_array['item_id'] = $article_id;
                        $upload_model->update($update_array);
                        unset($update_array);
                    }
                }
                //上传文章封面
                if (!empty($_FILES['_pic']['name'])) {
                    $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_ARTICLE;
                    $file = request()->file('_pic');
                    $result = $file->rule('uniqid')->validate(['ext' => 'jpg,png,gif'])->move($upload_file);
                    if ($result) {
                        $article_pic = $result->getFilename();
                        model('article')->editArticle(array('article_pic'=>$article_pic), $article_id);
                    } else {
                        // 上传失败获取错误信息
                        $this->error($file->getError(),url('Article/edit',['article_id'=>$article_id]));
                    }
                }
                $this->success(lang('ds_common_save_succ'), 'Article/index');
            } else {
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }

    public function edit() {
        $art_id = intval(input('param.article_id'));
        if ($art_id<=0) {
            $this->error(lang('param_error'));
        }
        $condition = array();
        $condition['article_id'] = $art_id;
        $article = model('article')->getOneArticle($condition);
        if(!$article){
            $this->error(lang('ds_no_record'));
        }
        if (!request()->isPost()) {
            $this->assign('article', $article);
            $articleclass_model = model('articleclass');
            $cate_list=$articleclass_model->getTreeClassList(2);
            $this->assign('ac_list', $cate_list);
            //附属图片
            $article_pic_list=model('upload')->getUploadList(array('upload_type'=>'1','item_id'=>$art_id));
            $this->assign('file_upload', $article_pic_list);
            $this->setAdminCurItem('edit');
            return $this->fetch('form');
        } else {
            $data = array(
                'article_title' => input('post.article_title'),
                'ac_id' => input('post.ac_id'),
                'article_url' => input('post.article_url'),
                'article_sort' => input('post.article_sort'),
                'article_content' => input('post.article_content'),
                'article_time' => TIMESTAMP,
            );
            $data['article_show'] = intval(input('post.article_show'));
            $article_validate = validate('article');
            if (!$article_validate->scene('edit')->check($data)) {
                $this->error($article_validate->getError());
            }

            //上传文章封面
            if (!empty($_FILES['_pic']['name'])) {
                $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_ARTICLE;
                $file = request()->file('_pic');
                $result = $file->rule('uniqid')->validate(['ext' => 'jpg,png,gif'])->move($upload_file);
                if ($result) {
                    //删除原图
                    if($article['article_pic']){
                        @unlink(BASE_UPLOAD_PATH . DS . ATTACH_ARTICLE . DS . $article['article_pic']);
                    }
                    $data['article_pic'] = $result->getFilename();
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError(), url('Article/edit', ['article_id' => $result]));
                }
            }
            //验证数据  END
            $result = model('article')->editArticle($data, $art_id);
            if ($result) {
                $this->success(lang('ds_common_save_succ'), 'Article/index');
            } else {
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }

    public function drop() {
        $article_id = input('param.article_id');
        if (empty($article_id)) {
            ds_json_encode(10001, lang('param_error'));
        }
        $condition = array();
        $condition['article_id'] = $article_id;
        $article = model('article')->getOneArticle($condition);
        if(!$article){
            ds_json_encode(10001, lang('ds_no_record'));
        }
        //删除图片
        if($article['article_pic']){
            @unlink(BASE_UPLOAD_PATH . DS . ATTACH_ARTICLE . DS . $article['article_pic']);
        }
        $article_pic_list=model('upload')->getUploadList(array('upload_type'=>'1','item_id'=>$article_id));
        foreach($article_pic_list as $article_pic){
            @unlink(BASE_UPLOAD_PATH . DS . ATTACH_ARTICLE . DS . $article_pic['file_name']);
        }
        $result = model('article')->delArticle($article_id);
        if ($result) {
            ds_json_encode(10000, lang('ds_common_op_succ'));
        } else {
            ds_json_encode(10001, lang('error'));
        }
    }

    /**
     * 文章图片上传
     */
    public function article_pic_upload() {
        $file_name = '';
        $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_ARTICLE . DS;
        $file_object = request()->file('fileupload');
        if ($file_object) {
            $info = $file_object->rule('uniqid')->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
            if ($info) {
                $file_name = $info->getFilename();
            } else {
                echo $file_object->getError();
                exit;
            }
        } else {
            echo 'error';
            exit;
        }
        
        /**
         * 模型实例化
         */
        $upload_model = model('upload');
        /**
         * 图片数据入库
         */
        $insert_array = array();
        $insert_array['file_name'] = $file_name;
        $insert_array['upload_type'] = '1';
        $insert_array['file_size'] = $_FILES['fileupload']['size'];
        $insert_array['item_id'] = intval(input('param.item_id'));
        $insert_array['upload_time'] = time();
        $result = $upload_model->addUpload($insert_array);
        if ($result) {
            $data = array();
            $data['file_id'] = $result;
            $data['file_name'] = $file_name;
            $data['file_path'] = UPLOAD_SITE_URL.'/' . ATTACH_ARTICLE . '/'.$file_name;
            /**
             * 整理为json格式
             */
            $output = json_encode($data);
            echo $output;
        }
    }

    /**
     * ajax操作
     */
    public function ajax() {
        switch (input('param.branch')) {
            /**
             * 删除文章图片
             */
            case 'del_file_upload':
                if (intval(input('param.file_id')) > 0) {
                    $upload_model = model('upload');
                    /**
                     * 删除图片
                     */
                    $file_array = $upload_model->getOneUpload(intval(input('param.file_id')));
                    @unlink(BASE_UPLOAD_PATH . DS . ATTACH_ARTICLE . DS . $file_array['file_name']);
                    /**
                     * 删除信息
                     */
                    $condition = array();
                    $condition['upload_id'] = intval(input('param.file_id'));
                    $upload_model->delUpload($condition);
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
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => lang('ds_manage'),
                'url' => url('Article/index')
            ),
        );

        if (request()->action() == 'add' || request()->action() == 'index') {
            $menu_array[] = array(
                'name' => 'add',
                'text' => lang('ds_new'),
                'url' => url('Article/add')
            );
        }
        if (request()->action() == 'edit') {
            $menu_array[] = array(
                'name' => 'edit',
                'text' => lang('ds_edit'),
                'url' => 'javascript:void(0)'
            );
        }
        return $menu_array;
    }

}