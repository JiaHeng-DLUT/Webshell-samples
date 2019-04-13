<?php
/**
 * 框架路由类
 *
 * Router::init(array $config); //传入参数进行初始化
 * $param=Router::makeUrl() //makeUrl方法执行，完成参数打包
 */
class Router {

    static private $var_controller;
    static private $var_module;
    static private $url_html_suffix;
    static private $url_pathinfo_depr;
 
    /**
     * 初始化方法
     * @param type $config
     */
    static public function init($config) {
        self::$var_module = isset($config['VAR_MODULE'])?$config['VAR_MODULE']:'index';
        self::$var_controller = isset($config['VAR_CONTROLLER'])?$config['VAR_CONTROLLER']:'index';
        self::$url_html_suffix =isset($config['URL_HTML_SUFFIX'])?$config['URL_HTML_SUFFIX']:'html';
        self::$url_pathinfo_depr = isset($config['URL_PATHINFO_DEPR'])?$config['URL_PATHINFO_DEPR']:'/';
    }
 
    /**
     * 获取url打包参数
     * @return type
     */
    static public function url() {
         return self::getParamByPathinfo();
    }
 

    /**
     * 获取参数通过pathinfo模式
     */
    static private function getParamByPathinfo() {

       $request_url = trim($_SERVER['REQUEST_URI'], '/');

//过滤请求的非法字符串
        if(!strpos(trim($request_url,'/'),'.'.self::$url_html_suffix)){
               
               return false;
        }else{

               $part0 = str_replace(strstr($request_url,'.'.self::$url_html_suffix),'',$request_url);
  
               $part0 = explode(self::$url_pathinfo_depr,trim($part0,'/'));
               $part1 =  empty($_SERVER['QUERY_STRING']) ? array(): explode('&', $_SERVER['QUERY_STRING']);
               $path_param = [];

               foreach($part1 as $k=>$v){
                 $arr = explode('=',$v);
                 if(count($arr) ==2){
                   $path_param[$arr[0]] = $arr[1];
                 }else{
                    $path_param = [];
                 }
               }
              

        }
     
         

        $part = str_replace('.'.self::$url_html_suffix,'',$part0);


        $data = array(
            'module' => '',
            'controller' => '',
        );
        if (!empty($part)) {
            krsort($part);
            $data['module'] = array_pop($part);
            $data['controller'] = array_pop($part);
        

            ksort($part);
            $part = array_values($part);
            $tmp = [];

            if (count($part) > 0) {
                foreach ($part as $k => $v) {
                    if ($k % 2 == 0) {
                        $tmp[$v] = isset($part[$k + 1]) ? $part[$k + 1] : '';
                    }
                }
            }
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':

                    $data = array_merge($tmp, $_GET,$data,$path_param);
                    
                    break;
                case 'POST':
                   

                    $data = array_merge($tmp, $_POST,$data,$path_param);
                   
                    break;
                case 'HEAD':
                    break;
                case 'PUT':
                    break;
            }
        }

        return $data;
    }

  
}