<?php

namespace app\common\model;

use think\Model;

/**
 * 会与标签
 */
class Snsmember extends Model{
    
    public $page_info;
    
    /**
     * 选择删除标签记录
     * @param type $condition
     * @return type
     */
    public function delSnsmembertag($condition){
        return db('snsmembertag')->where($condition)->delete();
    }
    
    /**
     * 获取会员标签列表
     * @param type $order
     * @param type $page
     * @return type
     */
    public function getSnsmembertagList($order,$page){
        if($page){
            $tag_list = db('snsmembertag')->order($order)->paginate(10, false, ['query' => request()->param()]);
            $this->page_info =$tag_list;
            return $tag_list->items();
        } else {
            return db('snsmembertag')->order($order)->select();
        }
    }
    
    /**
     *增加会员标签
     * @param type $data
     * @return type
     */
    public function addSnsmembertag($data){
        return db('snsmembertag')->insert($data);;
    }
    
    /**
     * 编辑会员标签
     * @param type $update
     * @return type
     */
    public function editSnsmembertag($update){
        return $result = db('snsmembertag')->update($update);;
    }
    
    /**
     * 获取单个会员标签
     * @param type $condition
     * @return type
     */
    public function getOneSnsmembertag($condition){
        return db('snsmembertag')->find($condition);
    }
    
    
    /**
     * 获取会员标签数
     * @param type $condition
     * @return type
     */
    public function getSnstagmemberCount($condition){
        return db('snsmtagmember')->where($condition)->count();;
    }
    
    /**
     * 获取所属标签会员列表
     * @param type $condition
     * @param type $field
     * @param type $page
     * @param type $order
     * @param type $count
     * @return type
     */
    public function getSnsmtagmemberList($condition,$field,$page,$order,$count){
        if($page){
            $result = db('snsmtagmember')->alias('s')->field($field)->join('__MEMBER__ m','s.member_id=m.member_id','LEFT')->where($condition)->order($order)->paginate($page,$count,['query' => request()->param()]);
            $this->page_info=$result;
            return $result->items();
        } else {
            $result = db('snsmtagmember')->alias('s')->field($field)->join('__MEMBER__ m','s.member_id=m.member_id','LEFT')->where($condition)->order($order)->select();
            return $result;
        }
        
    }
    
    /**
     * 删除所属标签会员
     * @param type $condition
     * @return type
     */
    public function delSnsmtagmember($condition){
        return db('snsmtagmember')->where($condition)->delete();
    }
    
    public function editSnsmtagmember($condition,$update){
        return db('snsmtagmember')->where($condition)->update($update);
    }
}
