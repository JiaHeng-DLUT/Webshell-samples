<?php
namespace app\common\model;
use think\Model;
class Base extends Model
{

/**
 * 增加数据 
 * @param  [string]        $data [数据]
 * @return [object]          [创建成功的对象]
 */

 
   public  function addData($data)
   {
       if(empty($data) || !is_array($data) )
       { 
          return false;
        }
        return self::create($data,true);
   }
  /**
   * 修改数据
   * @param  [string]        $data [数据]
   * @param  [string|array]  $where [条件]
   * @return [bool]          [true|false]
   */
   public  function editData($data,$where)
   {
    if(empty($data) || !is_array($data) )
    { 
          return false;
        }
    if(empty($where)){
        return false;
    }
	 return self::save($data,$where);
   }

  /**
   * 删除数据,支持单条删除和批量删除
   * @param  [string]        $where [条件]
   * @return [bool]          [true|false]
   */
   public  function delData($where){
      return self::where($where)->delete();

   }

    /**
     * [listData 获取多条数据]
     * @param  string $where [条件]
     * @param  string $field [字段]
     * @param  string $order [排序]
     * @param  string $limit [限制]
     * @return [array]        [返回数组]
     */
   public  function listData($where="",$field="*",$order="",$limit="")
    {
         
        
           return  $list = self::field($field)->where($where)->order($order)->limit($limit)->select()->toArray();

           
    }
    /**
     * [listPageData 获取带分页的多条数据列表]
     * @param  string $where [条件]
     * @param  string $field [允许的字段]
     * @param  string $order [排序]
     * @param  string $limit [限制]
     * @return [obj]        [返回对象]
     */
    public  function listPageData($where="",$field="*", $order="",$limit=10)
    {
         
        
           return  $list = self::field($field)->where($where)->order($order)->paginate($limit);

           
    }

    /**
     * [infoData 获取一条信息]
     * @param  [string|array] $where [条件]
     * @param  string $field         [字段]    
     * @return [string|bool]         [字符串或者布尔值]
     */
    public  function infoData($where, $field = '*')
    {
        if(empty($where))
        {
            return false;
        }
        $info = self::field($field)->where($where)->find();
       
        if(empty($info))
        {
            return false;
        }
        
        return $info;
    }
/**
 * [count 统计数据]
 * @param  string $where [条件]
 * @return [int]        [返回数字]
 */
  public  function count($where="",$field="*")
  {
    return self::field($field)->where($where)->count();
  }
    
}
