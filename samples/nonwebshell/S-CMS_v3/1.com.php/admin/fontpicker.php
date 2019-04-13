<?php 
require '../conn/conn2.php';
require '../conn/function.php';
?>
<link rel="stylesheet" href="../css/css/font-awesome.min.css?v=<?php echo gen_key(20)?>" type="text/css" />
<script src="js/jquery.min.js?v=<?php echo gen_key(20)?>"></script> <!-- 必需 -->
<style>
.box{padding: 10px;display: inline-block;cursor:pointer }
.box:hover{background: #DDDDDD;}
</style>
<script>
$(function(){
$(".box").click(function(){
    $('#U_ico', window.parent.document).val($(this).attr("data-f"));
    $('#U_icox', window.parent.document).html('<i class="fa fa-'+$(this).attr("data-f")+' fa-2x"></i>');
    parent.toastr.success("已选择图标："+$(this).attr("data-f"));
});
})
</script>
<?php 
$fonts=file_get_contents("font.txt");
$font=explode(PHP_EOL,$fonts);
for ($i=0;$i<count($font);$i++){
echo "<div class='box' data-f='".$font[$i]."'><i class='fa fa-".$font[$i]."'></i></div>";
}
?>