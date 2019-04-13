<?php

namespace app\common\model;

use think\Model;

class Document extends Model {

    /**
     * 查询所有系统文章
     * @access public
     * @author csdeshang 
     * @return type
     */
    public function getDocumentList() {
        return db('document')->select();
    }

    /**
     * 根据编号查询一条
     * @access public
     * @author csdeshang 
     * @param int $id 文章id
     * @return array
     */
    public function getOneDocumentById($id) {
        return db('document')->where('document_id',$id)->find();
    }

    /**
     * 根据标识码查询一条
     * @access public
     * @author csdeshang
     * @param type $code 标识码
     * @return type
     */
    public function getOneDocumentByCode($code) {
        return db('document')->where('document_code',$code)->find();
    }

    /**
     * 更新
     * @access public
     * @author csdeshang
     * @param array $data 更新数据
     * @return bool
     */
    public function editDocument($data) {
        return db('document')->where('document_id',$data['document_id'])->update($data);
    }
}

?>
