<?php
namespace app\common\model;
use think\Model;

class Article extends Model
{
    public $page_info;
    /**
     * 获取文章列表
     * @access public
     * @author csdeshang
     * @param type $condition
     * @param type $page
     * @param type $order
     * @return type
     */
    public function getArticleList($condition,$page='',$order='article_sort asc,article_time desc'){
        if ($page) {
            $result = db('article')->where($condition)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        } else {
            return db('article')->where($condition)->order($order)->limit(10)->select();
        }
    }

    /**
     * 连接查询列表
     * @access public
     * @author csdeshang
     * @param type $where
     * @param type $limit
     * @param type $field
     * @param type $order
     * @return type
     */
    public function getJoinArticleList($where,$limit=0,$field='*',$order='article.article_sort'){
        $result = db('article')->alias('article')->join('__ARTICLECLASS__ article_class','article.ac_id=article_class.ac_id','LEFT')->field($field)->where($where)->limit($limit)->order($order)->select();
        return $result;
    }


    /**
     * 取单个内容
     * @access public
     * @author csdeshang
     * @param int $condition
     * @return array 数组类型的返回结果
     */
    public function getOneArticle($condition){
        $result = db('article')->where($condition)->find();
        return $result;
    }

    /**
     * 新增
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addArticle($data){
        $result = db('article')->insertGetId($data);
        return $result;
    }

    /**
     * 更新信息
     * @access public
     * @author csdeshang
     * @param array $data 更新数据
     * @return bool 布尔类型的返回结果
     */
    public function editArticle($data,$article_id){
        $result = db('article')->where("article_id=".$article_id)->update($data);
        return $result;
    }

    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param int $id 记录ID
     * @return bool 布尔类型的返回结果
     */
    public function delArticle($id){
        return db('article')->where("article_id=".$id)->delete();
    }
}