<?php
/**
 * Project: Catfish.
 * Author: A.J
 * Date: 2016/10/3
 */
namespace app\admin\controller;

class Tree{

    protected static $config = [
        'primary_key' 	=> 'id',
        'parent_key'  	=> 'parent_id',
        'children_key'  => 'children',
    ];
    protected static $result = [];
    protected static $level = [];
    public static function makeTree($data,$options=[] ){
        $dataset = self::buildData($data,$options);
        $r = self::makeTreeCore(0,$dataset,'normal');
        return $r;
    }
    public static function makeTreeForHtml($data,$options=[]){
        self::$result = [];
        $dataset = self::buildData($data,$options);
        $r = self::makeTreeCore(0,$dataset,'linear');
        return $r;
    }
    private static function buildData($data,$options){
        $config = array_merge(self::$config,$options);
        self::$config = $config;
        extract($config);

        $r = [];
        foreach($data as $item){
            $id = $item[$primary_key];
            $parent_id = $item[$parent_key];
            $r[$parent_id][$id] = $item;
        }

        return $r;
    }
    private static function makeTreeCore($index,$data,$type='linear')
    {
        extract(self::$config);
        foreach($data[$index] as $id=>$item)
        {
            if($type=='normal'){
                if(isset($data[$id]))
                {
                    $item[$children_key]= self::makeTreeCore($id,$data,$type);
                }
                $r[] = $item;
            }else if($type=='linear'){
                $parent_id = $item[$parent_key];
                self::$level[$id] = $index==0?0:self::$level[$parent_id]+1;
                $item['level'] = self::$level[$id];
                self::$result[] = $item;
                if(isset($data[$id])){
                    self::makeTreeCore($id,$data,$type);
                }

                $r = self::$result;
            }
        }
        return $r;
    }
}