<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace app\common\taglib;
use think\Db;
use think\template\TagLib;

class Qilecms extends Taglib
{
        // 标签定义
    protected $tags = [
      'tag'        => ['attr' => '','close' => 1],  //万能标签
      'ad'         => ['attr' => 'position_id', 'close' => 0], 
      'nav'        => ['attr' => '', 'close' => 1],
      'mobilenav'  => ['attr' => '', 'close' => 1],
      'friendlink' => ['attr' => '', 'close' => 1],
      'ad'         => ['attr' => 'position_id', 'close' => 0],   
      'guestbook'  => ['attr' => 'name,key,order,limit', 'close' => 1],   

    
    ];

/**
 * [tagTags 万能查询标签]
 * @param  [type] $tag     [description]
 * @param  [type] $content [description]
 * @return [type]          [description]
 */
    public function tagTag($tag, $content)
    {    
         $id        =!empty($tag['id'])?$tag['id']:'vo';
         $key       =!empty($tag['key'])?$tag['key']:'key';

         $table     =!empty($tag['table'])?$tag['table']:''; //数据表
         $field     =!empty($tag['field'])?$tag['field']:'*'; //字段限制
         $order     =!empty($tag['order'])?$tag['order']:''; //排序
         $limit     =!empty($tag['limit'])?intval($tag['limit']):'10'; //分分页限制
         $where     =!empty($tag['where'])?$tag['where']:' 1 '; //条件
        
         $alias     =!empty($tag['alias'])?$tag['alias']:''; //条件
         $join      =!empty($tag['join'])?$tag['join']:''; //条件
         $expires   =!empty($tag['expires'])?intval($tag['expires']):30; //缓存过期时间
         $sql       =!empty($tag['sql'])?$tag['sql']:''; //纯sql
         $debug     =!empty($tag['debug'])?$tag['debug']:false;  //调试模式
    
        $parse  = '<?php ';
        if($sql){
            //原生查询
            $parse .= '$__LIST__    = Db::query("'.$sql.'");';
        }else{
         
            //非原生查询
           $parse .= '$__LIST__  =Db::name("'.$table.'")';
            if(!empty($alias)){
              $parse .= '->alias("'.$alias.'")';
            }
            if(!empty($join)){
              $parse .= '->join("'.$join.'")';
            }
            if(!empty($field)){
              $parse .='->field("'.$field.'")';
            }
            if(!empty($expires)){
              $parse .= '->cache("'.$expires.'")';
            }
            if(!empty($where)){
              $parse .= '->where("'.$where.'")';
            }
            if(!empty($order)){
               $parse .='->order("'.$order.'")';
            }
           $parse .= '->paginate("'.$limit.'");';

           $parse .='$page = $__LIST__->render();'; //渲染分页      
        }

        if($debug!=false){
            $parse.='dump(Db::name("'.$table.'")->getLastSql());dump($__LIST__);';
         } 
        $parse .= ' ?>';
      
        $parse .= '{volist name="__LIST__"  id="'.$id.'"  key="'.$key.'"}';
        $parse .=  $content;
        $parse .= '{/volist}';
        return $parse;
    }
    /**
     * 前台导航标签
     * @param name string 导航循环变量名称
     * @param id int|string 导航数据id  大于0的正数或者字符串
     * @param pid int|string 导航父类id 大于等于0的正数或者字符串
     * @param limit int 限制显示数量
     * @return array  一维数组
     */
    public function tagNav($tag, $content)
    {

        $name  = !empty($tag['name'])?$tag['name']:'vo'; // 循环变量名称
        $limit = !empty($tag['limit'])?$tag['limit']:''; //显示数量
        $id    = !empty($tag['id'])?$tag['id']:''; //导航数据ID, 
        $pid   = isset($tag['pid'])?$tag['pid']:0; //导航父类ID
        $order = 'sort desc'; //默认排序
        $where = 'status = 1';  //显示
        if(!empty($id)){
           $where .= ' and id IN ('.$id.')';
        }
        if(isset($pid)){
           $where .= '  and pid IN ('.$pid.')';
        }
        $field = 'id,pid,url,target,icon,name';
        $parse = '<?php ';
        $parse .= '$__LIST__  = Db::name("nav")->field("'.$field.'")->where("'.$where.'")->order("'.$order.'")->limit("'.$limit.'")->select();';
        // print_r($__LIST__);
        //指定id数据，不进行排序操作
        if(empty($id)){
          $parse .= '$__LIST__ = list_to_tree($__LIST__);';
        }
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="' . $name . '"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }
     /**
     * 手机导航标签
     * @param name string 导航循环变量名称
     * @param limit int 限制显示数量
     * @return array  一维数组
     */
    public function tagMobileNav($tag,$content)
    {

        $name  = !empty($tag['name'])?$tag['name']:'vo'; // 循环变量名称
        $limit = !empty($tag['limit'])?$tag['limit']:''; //显示数量
        $id    = !empty($tag['id'])?$tag['id']:''; //导航数据ID, 
        $pid   = isset($tag['pid'])?$tag['pid']:null; //导航父类ID
        $order = 'sort desc'; //默认排序
        $where = 'is_wap = 1';  //显示
        if(!empty($id)){
           $where .= ' and id IN ('.$id.')';
        }
        if(isset($pid)){
           $where .= '  and pid IN ('.$pid.')';
        }
        $field = 'id,pid,url,target,icon,name';
        $parse = '<?php ';
        $parse .= '$__LIST__  = Db::name("nav")->field("'.$field.'")->where("'.$where.'")->order("'.$order.'")->limit("'.$limit.'")->select();';
      //指定id数据，不进行排序操作
        if(empty($id)){
          $parse .= '$__LIST__ = list_to_tree($__LIST__);';
        }
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="'.$name .'"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }

     /**
     * 友情链接标签
     * @param name string 友情链接名称
     * @param limit int 限制显示数量
     * @param id int 数据id显示数量
     * @return array 一维数组
     */
    public function tagFriendLink($tag,$content)
    {

        $name  = !empty($tag['name'])?$tag['name']:'vo'; // 
        $limit = !empty($tag['limit'])?$tag['limit']:''; //显示数量
        $id    = !empty($tag['id'])?$tag['id']:''; //数据ID编号
        $order = 'create_time desc,sort desc'; //默认排序
         $where = 'status = 1';  //显示
        if($id){
           $where .= ' and fid IN('.$id.')';
        }
        $field = 'logo,url,name';
        $parse = '<?php ';
        $parse .= '$__LIST__  = Db::name("friendlink")->field("'.$field.'")->where("'.$where.'")->order("'.$order.'")->limit("'.$limit.'")->select();';
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="'.$name .'"}';
        $parse .= $content;
        $parse .= '{/volist}';
        return $parse;
    }
//公告标签


     /**
     * 广告标签
     * @param name string 循环变量名称
     * @param limit int 限制显示数量
     * @param id int 数据id显示数量
     * @return array 一维数组
     */
    public function tagAd($tag)
    {

        $name  = !empty($tag['name'])?$tag['name']:'vo'; // 
        // $id    = !empty($tag['id'])?$tag['id']:''; //广告数据ID
        $position_id    = $tag['position_id']; //广告位数据ID
        $limit = !empty($tag['limit'])?$tag['limit']:''; //显示数量
        $order = 'create_time desc,sort desc';         //默认排序
        $where = ' position_id = '.$position_id.' and status = 1';  //显示
 
 //多城市广告显示
        $city_id = cookie('city_id'); //城市数据ID
        if(!empty($city_id)){
          $where .= ' and city_id IN('.$city_id.')';
        }
        $field = 'url,ad_img,code';
        $parse = '<?php ';
        $parse .= '$__LIST__  = Db::name("ad")->field("'.$field.'")->where("'.$where.'")->order("'.$order.'")->limit("'.$limit.'")->select();';

        $parse .= ' ?>';
        return $parse;
    }
// 留言本标签，带分页
   public  function tagGuestbook($tag,$content)
   {
        
        $name  = !empty($tag['name'])?$tag['name']:'vo'; // 
        $key   = !empty($tag['key'])?$tag['key']:'key'; //key
        $paging = !empty($tag['paging'])?$tag['paging']:'no'; //
        $order = !empty($tag['order'])?$tag['order']:''; //排序
        $limit = !empty($tag['limit'])?$tag['limit']:'10'; //
        $field = !empty($tag['field'])?$tag['field']:''; //
  
        $where = "status =1";  //正常状态的浏览

   	    $parse = '<?php ';
        $parse .= '$__LIST__  =  Db::name("guestbook")->field("'.$field.'")->where("'.$where.'")->order("'.$order.'")->paginate("'.$limit.'");';
        if($tag['paging'] =='yes'){
        	$parse .= '$page = $__LIST__->render();';
        }
        $parse .= ' ?>';
        $parse .= '{volist name="__LIST__" id="'.$name.'" key="'.$key.'"}';
        $parse .= $content;
        $parse .= '{/volist}';
         return $parse;
   }

}
