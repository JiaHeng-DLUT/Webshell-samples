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

use think\template\TagLib;

class Form extends Taglib
{
        // 标签定义
    protected $tags = [
      'iframe'     =>  ['attr' => 'name,display', 'close' => 0],
      'ueditor'    =>  ['attr' => 'name,value,width,height', 'close' => 0], //闭合标签，默认为不闭合
      'input'      =>  ['attr' => 'name,type,value,default,title,checked,', 'close' => 0], //闭合标签，默认为不闭合
      'close'      =>  ['attr' => 'time,format', 'close' => 0], //闭合标签，默认为不闭合
    ];

    /**
     * Iframe标签解析
     * 格式：
     * {form:iframe  name="m-iframe" display="true"/}
     * @access public
     * @param array $tag 标签属性
     * @return string
     */
       public function tagIframe($tag)
    {
         $name  = !empty($tag['name'])?$tag['name']:'iframe';
         $display = $tag['display'] == true ?'block':'none';  
         $parse = '<iframe name="'.$name.'" id="'.$name.'" class="'.$name.'" style="width:100%;top:0;display:'.$display.'" ></iframe>';
  
         return $parse;
    } 
    /**
     * Input标签解析
     * 格式：
     * 
     * @access public
     * @param array $tag 标签属性
     * @return string
     */
       public function tagInput($tag)
    {
         $name  = !empty($tag['name'])?$tag['name']:'';
         $type  = !empty($tag['type'])?$tag['type']:'text';
         $default  = !empty($tag['default'])?$tag['default']:'';
         $value  = !empty($tag['value'])?'<?php echo '.$tag['value'].';?>':'';
         $title  = !empty($tag['title'])?$tag['title']:'';
         // $display = $tag['display'] == true ?'block':'none'; 
         if($type == 'radio'){
          //单选框
          $checked  = !empty($tag['checked'])?'<?php echo '.$tag['checked'].';?>':'';
          $parse = '<input type="radio" name="'.$name.'" class="layui-input '.$name.'" id="'.$name.'" lay-verify="'.'.$name.'.'" autocomplete="off"    '.$checked.' title="'.$title.'">';
         }else{
          $parse = '<input type="'.$type.'" name="'.$name.'" class="layui-input '.$name.'" id="'.$name.'" lay-verify="'.$name.'" autocomplete="off" placeholder="'.$default.'" value="'.$value.'">';          
         } 

         return $parse;
    } 



    /**
     * Ueditor标签解析
     * 格式：
     * {form:iframe  name="m-iframe" display="true"/}
     * @access public
     * @param array $tag 标签属性
     * @return string
     */
       public function tagUeditor($tag)
    {
    
$images_path = !empty($settings['attachments']['images_path'])?$settings['attachments']['images_path']:config('app.upload_images.path');  
         $imagePathFormat = $images_path."{yyyy}{mm}{dd}";
         $name   = !empty($tag['name'])?$tag['name']:'content';
         $value  =  !empty($tag['value'])?'<?php echo '.$tag['value'].';?>':'';
         $width  = !empty($tag['width'])?$tag['width']:'100%';
         $height  = !empty($tag['height'])?$tag['height']:'350px';
         // $id  = !empty($tag['id'])?$tag['id']:'container';
         $parse ='<!-- 加载编辑器的容器 -->
<script id="container-'.$name.'" name="'.$name.'" type="text/plain">'.$value.'</script>
              <!-- 配置文件 -->
              <style>#container-'.$name.' .edui-editor-iframeholder{width:'.$width.' !important;min-height:'.$height.' !important;}</style>
              <!-- 实例化编辑器 -->
              <script type="text/javascript">
                  var ue = UE.getEditor("container-'.$name.'",{
                      autoHeightEnabled:false,
                      catchRemoteImageEnable: true,
                      imagePathFormat: "'.$imagePathFormat.'",
                toolbars: [
                 ["bold","insertorderedlist","insertunorderedlist","justifycent","justifyright","simpleupload","removeformat", "undo", "redo", ]
                 ],
                  });
              </script>';
         return $parse;
    } 
    /*
     * 这是一个闭合标签的简单演示
    */
    public function tagClose($tag)
    {
        $format = empty($tag['format']) ? 'Y-m-d H:i:s' : $tag['format'];
        $time = empty($tag['time']) ? time() : $tag['time'];
        $parse = '<?php ';
        $parse .= 'echo date("' . $format . '",' . $time . ');';
       $parse .= ' ?>';
        return $parse;
    }


}