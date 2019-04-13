<footer class="page-footer">       
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-6">  
          <div class="page-copyright">
             <p><?php echo lang($C_foot)?>
             
             </p>
          </div>       
        </div>
        <div class="col-xs-12 col-sm-6">
              <p class="yto-tel">
              <a target="_blank" class="link-yto" href="../"><?php echo lang("官网首页/l/Home Page")?></a>
              <?php 
		$qq=explode(",",lang($C_qq));
		for ($i = 0 ;$i< count($qq);$i++){
		
		if (strpos($qq[$i],"|")!==false){
		
		if (is_numeric(splitx($qq[$i],"|",0))){
		$QQkefu=$QQkefu."<a title='".lang("点击这里给我发消息/l/Click here to send me a message.")."' href='http://wpa.qq.com/msgrd?v=3.uin=".splitx($qq[$i],"|",0).".site=qq.menu=yes' target='_blank' class='link-yto'><i class='fa fa-qq'></i> ".splitx($qq[$i],"|",1)."</a> ";
		}else{
		$QQkefu=$QQkefu."<a title='".lang("点击这里给我发消息/l/Click here to send me a message.")."' href='http://www.taobao.com/webww/ww.php?ver=3.touid=".urlencode(splitx($qq[$i],"|",0)).".siteid=cntaobao.status=1.charset=utf-8' target='_blank' class='link-yto'><i class='fa fa-twitch'></i> ".splitx($qq[$i],"|",1)."</a> ";
		}
		}else{
		
		if (Is_Numeric(splitx($qq[$i]."|","|",0))){
		$QQkefu=$QQkefu."<a title='".lang("点击这里给我发消息/l/Click here to send me a message.")."' href='http://wpa.qq.com/msgrd?v=3.uin=".splitx($qq[$i]."|","|",0).".site=qq.menu=yes' target='_blank' class='link-yto'><i class='fa fa-qq'></i> ".splitx($qq[$i]."|","|",1)."</a> ";
		}else{
		$QQkefu=$QQkefu."<a title='".lang("点击这里给我发消息/l/Click here to send me a message.")."' href='http://www.taobao.com/webww/ww.php?ver=3.touid=".urlencode(splitx($qq[$i]."|","|",0)).".siteid=cntaobao.status=1.charset=utf-8' target='_blank' class='link-yto'><i class='fa fa-twitch'></i> ".splitx($qq[$i]."|","|",1)."</a> ";
		}
		}
		}
		echo $QQkefu;
			  
			  ?>
              </p>  
        </div>
      </div>
    </div>
  </footer>