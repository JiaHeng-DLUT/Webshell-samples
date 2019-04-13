<div class="main_grid_contact_test1">
<h3> 自定义表单，必须懂前端。</h3>
				 
					<div class="row top-inputs-agile">
						<div class="col-md-4 form-group">
							<input class="form-control" type="text" name="Name" placeholder="昵称" required="">
						</div>
						<div class="col-md-4 form-group px-md-0">
							<input class="form-control" type="email" name="Email" placeholder="Email" required="">
						</div>
						<div class="col-md-4 form-group">
							<input class="form-control" type="text" name="sublect" placeholder="标题" required="">
						</div>
					</div>
					<div class="form-group">
						<textarea id="textarea" name="message" placeholder="内容"></textarea>
					</div>
					<div class="input-group1">
						<input class="form-control submit cp" type="submit" value="提交">
					</div>
			 
			</div>
	 <script>
  $('#<?php echo $formrand?> .submit').click(function() {
	   var parentv = $(this).closest('.formblock'); //parentv for multi form js .
	    
	      //第一步，先验证表单，通过后，再第二步，取得所有input的值，合并到content里。
		  //比如，content结果为：
		  var content = '名称：张三<br>内容: 请问如何定制DM表单？。。。。。等等其他内容。。。。。'
	   
	     //最后再通过ajax发送到后台。
		 dmformajax(parentv,content,<?php echo $formrand ?>);
	   	 
               
    });
	
 //console.log(formdata); 

</script>