<?php 

if ($M_name!="未填写" && $M_name!=""){
  $f1=1.0;
}else{
  $f1=0.0;
}
if($M_code!="未填写" && $M_code!=""){
  $f2=1.0;
}else{
  $f2=0.0;
}
if($M_qq!="未填写" && $M_qq!=""){
  $f3=1.0;
}else{
  $f3=0.0;
}
if($M_mobile!="未填写" && $M_mobile!=""){
  $f4=1.0;
}else{
  $f4=0.0;
}
if($M_add!="未填写" && $M_add!=""){
  $f5=1.0;
}else{
  $f5=0.0;
}
if($M_email!="未填写" && $M_email!=""){
  $f6=1.0;
}else{
  $f6=0.0;
}
if($M_pic!=$C_dir."media/member.jpg"){
  $f7=1.0;
}else{
  $f7=0.0;
}

if($f1+$f2+$f3+$f4+$f5+$f6+$f7==7){

  $sql="Select * from SL_list where L_title like '完善资料' and L_mid=".$_SESSION["M_id"];
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  if (mysqli_num_rows($result) > 0) {

  }else{
      mysqli_query($conn,"update SL_member set M_fen=M_fen+".$C_data." where M_id=".$_SESSION["M_id"]);
      mysqli_query($conn,"insert into SL_list(L_title,L_mid,L_change,L_time,L_type) values('完善资料',".$_SESSION["M_id"].",".$C_data.",'".date('Y-m-d H:i:s')."',1)");
  }
}

function getfen($M_lv){
  global $conn;
  $sql="Select * from SL_lv where L_id>".$M_lv." order by L_id asc limit 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
    $getfen=$row["L_fen"];
    }else{
    $sql2="Select * from SL_lv  order by L_id desc limit 1";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $getfen=$row2["L_fen"];
            }
            return $getfen;
        }

?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form action="index.php?action=tomoney" method="post">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" 
            aria-hidden="true">×
        </button>
        <h4 class="modal-title" id="myModalLabel">
          积分转余额
        </h4>
      </div>
      <div class="modal-body">
      输入需要转换的积分：
      <input class="form-control" name="fen" placeholder="分" />
        说明：每1积分可转余额<?php echo round($C_tomoney_rate,2)?>元。
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" 
            data-dismiss="modal">关闭
        </button>
        <button type="submit" class="btn btn-primary">
          提交
        </button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</form>
</div><!-- /.modal -->

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form action="index.php?action=tofen" method="post">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" 
            aria-hidden="true">×
        </button>
        <h4 class="modal-title" id="myModalLabel">
          余额转积分
        </h4>
      </div>
      <div class="modal-body">
      输入需要转换的余额：
      <input class="form-control" name="money" placeholder="元"/>
        说明：每1元可转<?php echo $C_tofen_rate?>积分。
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" 
            data-dismiss="modal">关闭
        </button>
        <button type="submit" class="btn btn-primary">
          提交
        </button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </form>
</div>

<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form action="index.php?action=tx" method="post">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" 
            aria-hidden="true">×
        </button>
        <h4 class="modal-title" id="myModalLabel">
          余额提现
        </h4>
      </div>
      <div class="modal-body">
      提现金额：
      <input class="form-control" name="money" placeholder="元"/>
      支付宝帐号：
      <input class="form-control" name="alipay" />
      真实姓名：
      <input class="form-control" name="name"/>
        说明：每次提现收取<?php echo $C_tx_rate?>%手续费。
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" 
            data-dismiss="modal">关闭
        </button>
        <button type="submit" class="btn btn-primary">
          提交
        </button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </form>
</div>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle navbar-menubar" id="menu">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#userinfo" aria-expanded="false">
        <span class="icon fa-user"></span>
      </button>
      <a class="navbar-brand" href="../index.php">
        <img title="<?php echo lang(" 会员中心/l/Member Center ")?>" src="<?php echo $C_dir.$C_logo?>" class="navbar-brand-logo" height="60">
        
      </a>
      <span class="navbar-brand-text"></div>
    <div class="collapse navbar-collapse" id="userinfo">
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="index.php" class="navbar-avatar dropdown-toggle">
            <span class="avatar">
              <img alt="..." src="<?php echo $M_pic?>"></span>
            <span class="user-name">
              <?php echo $M_login?></span>
          </a>
        </li>
        <li>
          <a href="member_login.php?action=unlogin"><?php echo lang("退出/l/Quit")?></a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="site-menubar navbar-nav">
  <div class="site-menubar-body">
    <ul class="site-menu">
      <li class="site-menu-item">
        <a href="index.php">
          <i class="icon" aria-hidden="true" title="10000"></i>
          <span class="site-menu-title"><?php echo lang("会员中心/l/Member")?></span></a>
        <ul class="dropdown-menu"></ul>
      </li>
      <li class="site-menu-item">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          <i class="icon" aria-hidden="true" title="40000"></i>
          <span class="site-menu-title"><?php echo lang("我的购物/l/buy")?></span>
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li>
            <a href="member_order.php?type=0"><?php echo lang("购物车/l/Shopping Cart")?></a>
          </li>
          <li>
            <a href="member_order.php"><?php echo lang("全部订单/l/Orders")?></a>
          </li>
          
        </ul>
      </li>
      <li class="site-menu-item">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          <i class="icon" aria-hidden="true" title="50000"></i>
          <span class="site-menu-title"><?php echo lang("文章投稿/l/Submission")?></span>
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
		<li>
            <a href="member_newsinfo.php"><?php echo lang("我要投稿/l/Submission")?></a>
          </li>
          <li>
            <a href="member_news.php?type=0"><?php echo lang("已通过/l/Passed")?></a>
          </li>
          <li>
            <a href="member_news.php?type=1"><?php echo lang("未通过/l/Failed")?></a>
          </li>
          <li>
            <a href="member_news.php?type=2"><?php echo lang("未审核/l/Not audited")?></a></li>
        </ul>
      </li>
      <li class="site-menu-item">
        <a href="member_form.php">
          <i class="icon" aria-hidden="true" title="60000"></i>
          <span class="site-menu-title"><?php echo lang("表单管理/l/Forms")?></span>
          <ul class="dropdown-menu"></ul>
        </a>
        
      </li>
      <li class="site-menu-item">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          <i class="icon" aria-hidden="true" title="20000"></i>
          <span class="site-menu-title"><?php echo lang("用户信息/l/information")?></span>
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
         <li><a href="member_edit.php"><?php echo lang("用户信息/l/information")?></a></li>
         <li><a href="member_email.php"><?php echo lang("绑定邮箱/l/email")?></a></li>
         <li><a href="member_mobile.php"><?php echo lang("绑定手机/l/mobile")?></a></li>
         <li><a href="member_pwdedit.php"><?php echo lang("密码修改/l/Password")?></a></li>
        </ul>
      </li>
      <li class="site-menu-item">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          <i class="icon" aria-hidden="true" title="90000"></i>
          <span class="site-menu-title">我的财富</span>
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
		<li>
            <a href="member_moneylist.php">余额明细</a></li>
          <li>
          <li>
            <a href="invoice_list.php">发票管理</a></li>
          <li>
            <a href="member_fenlist.php">积分明细</a></li>
			<li>
            <a href="member_role.php">奖励规则</a></li>
			<?php if ($C_gifton==1){ ?>
			<li><a href="member_gift.php">兑换礼品</a></li>
			<?php }?>
        </ul>
      </li>
    </ul>
  </div>
</div>
<div class="page">
  <div class="page-header">

    <div class="container">
      <div class="row">
	  
	  
        <div class="col-xs-5 col-sm-2">
          <div class="my-avatar pull-right">
            <span class="avatar">
              <img alt="..." src="<?php echo $M_pic?>">
              <label class="badge">
                <?php echo $L_title?></label>
            </span>
			<div style="padding-top:10px;">
			<a href="index.php?action=sign"><span style="background-color: #f0ad4e; color:#FFFFFF; padding:2px 5px;border-radius: 5px; font-weight:bold;">签到</span></a>
			<a href="member_role.php"> <span style="background-color: #5cb85c; color:#FFFFFF; padding:2px 5px;border-radius: 5px; font-weight:bold;">邀请</span></a>
			</div>
          </div>
        </div>
		
		
        <div class="col-xs-7 col-sm-3">
          <p class="font-size-16">
            <strong>
              <?php echo $M_login?></strong>
          </p>
          <p class="font-size-16">
            <?php echo $L_title?></p>
          <p class="hidden-xs">信息完整度</p>
          <div class="progress info-w hidden-xs">
            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo floor(($f1+$f2+$f3+$f4+$f5+$f6+$f7)/7*100)?>%"><?php echo floor(($f1+$f2+$f3+$f4+$f5+$f6+$f7)/7*100)?>%</div></div>
          <?php if (($f1+$f2+$f3+$f4+$f5+$f6+$f7)/7<1) {?>
		  
		  <?php if ($C_data<>0){ ?><p>完善个人信息送<?php echo $C_data?>积分
            <a href="member_edit.php">立即完善</a>
            <br></p>
			<?php }?>
			<?php }?>
        </div>
        <div class="col-xs-6 col-sm-4">
          <p class="font-size-16">
            <strong>我的财富</strong></p>
          <ul class="list-inline">
            <li class="p_top_10  col-coupon">
              <a href="member_fenlist.php" class="badge">
                <?php echo $M_fen?></a>
              <p class="p-xs">我的积分 <?php if ($C_tomoney==1){?><a href="javascript:;" data-toggle="modal" data-target="#myModal" class="btn btn-xs btn-info">转</a><?php }?></p></li>
            <li class="p_top_10 p_left_20 col-integral">
              <a href="member_pay2.php" class="badge">
                <?php echo round($M_money,2)?></a> 元
              <p class="p-xs">我的余额 <?php if ($C_tofen==1){?><a href="javascript:;" style="margin-right:10px;" data-toggle="modal" data-target="#myModal2" class="btn btn-xs btn-info">转</a><?php }?> <?php if ($C_tx==1){?><a href="javascript:;" data-toggle="modal" data-target="#myModal3"  class="btn btn-xs btn-warning">提现</a><?php }?></p></li>
          </ul>
          <!-- <p class="p-xs">
          <a href="#">如何使用积分？</a></p> -->
        </div>
        <div class="col-xs-12 col-sm-3 yto-vip">
          <p class="font-size-16">
            <strong>会员成长</strong></p>
          <ul class="list-inline">
            <li>
              <span>当前积分：<?php echo $M_fen?>
                <br></span></li>
            <li>升级还需：
<?php 
if (getfen($M_lv)>$M_fen){
      echo getfen($M_lv)-$M_fen;
      }else{
      echo "0";
      }
?>
              </li>
            <li>
              <div class="yto-vip-progress">
                <span class="badge">
                  <?php echo $L_title?></span>
                <div class="progress">
                  <div id="maypoint" data-point="15" data-nextpoint="986" class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:<?php 
				  if ($M_fen/getfen($M_lv)<1){
          echo $M_fen/getfen($M_lv)*100;
          }else{
          echo 100;
          }
				  
				  ?>%">
         <?php 
				  if ($M_fen/getfen($M_lv)<1){
          echo round($M_fen/getfen($M_lv)*100,2);
          }else{
          echo 100;
          }
				  
				  ?>%</div></div>
              </div>
              <p class="m_bottom_0">升级后，您将得到更大的折扣优惠，赶紧赚取积分吧！
                <br>
                <a href="member_role.php">查看积分奖励规则</a></p>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  