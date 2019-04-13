<?php

namespace app\common\model;


use think\Model;

class Link extends Model
{
    public $page_info;
    /**
     * 友情链接列表
     * @access public
     * @author csdeshang
     * @param type $condition  查询条件
     * @param type $page       分页页数
     * @param type $order      排序
     * @return type            返回结果
     */
    public function getLinkList($condition = '', $page = '',$order='link_sort asc')
    {
        if ($page) {
            $result = db('link')->where($condition)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        }else{
            return db('link')->where($condition)->order($order)->select();
        }
    }

    /**
     * 取单个友情链接
     * @access public
     * @author csdeshang
     * @param type $id 链接ID
     * @return type
     */
    public function getOneLink($id)
    {
        return db('link')->where('link_id',$id)->find();
    }

    /**
     * 新增友情链接
     * @access public
     * @author csdeshang
     * @param type $data 参数内容
     * @return type
     */
    public function addLink($data)
    {
        return db('link')->insertGetId($data);
    }

    /**
     * 更新友情链接  
     * @access public
     * @author csdeshang
     * @param type $data 更新数据
     * @param type $link_id 链接id
     * @return type
     */
    public function editLink($data,$link_id)
    {
        return db('link')->where('link_id',$link_id)->update($data);
    }

    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param array $id 链接id
     * @return bool
     */
    public function delLink($id)
    {
        $link = $this->getOneLink($id);
        //删除友情链接图片
        @unlink(BASE_UPLOAD_PATH . DS . DIR_ADMIN . DS .'link'.DS.$link['link_pic']);
        return db('link')->where('link_id',intval($id))->delete();
    }
}