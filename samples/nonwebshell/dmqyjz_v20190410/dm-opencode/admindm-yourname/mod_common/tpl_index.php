 
			<div class="pa20" style="line-height:35px;font-size:16px;padding-bottom:200px">
			
		   
		   
						   欢迎使用DM企业建站系统，<br />
						   DM系统专注中小企业网站建设！<br />
						   DM系统开源，免费，无需授权！助力中小企业网站建设。 
						    
						   <br /><br />
						
						   使用DM建站，<a  style="color:blue;font-size:16px" target="_blank" href="<?php echo $dmlink_sp;?>">请先观看视频教程></a>
						   </span>
		   
		   
		   <div class="" style="padding:20px 0;font-size:14px">
			   
		   <strong style="font-size:20px">------------------
		   <br />
		   
		   服务器或空间的信息：</strong>
		   
		   <br /> 
		   <?php
		   $sysos = $_SERVER["SERVER_SOFTWARE"];      //获取服务器标识的字串
		   $sysversion = PHP_VERSION;                   //获取PHP服务器版本
			
			
			
		   $systemtime = date("Y-m-d H:i:s",time());
			
		   echo "  Web服务器：    $sysos       <br />";
		   echo "  PHP版本：      $sysversion   <br />";
			
			
		   ?> 
		   ----------<br /> 
		   DM系统必须支持伪静态，如果是apache，则根目录必须有.htaccess文件。<br /> 
		   如果是IIS，则可能是.htaccess或是web.config<br /> 
		   如果是nginx(百度主机) ，则请参考根目录的bcloud_nginx_user.conf<br /> 
		   
		   
		   </div>
		   
		   
		   
						   </div>
		   
			
		   