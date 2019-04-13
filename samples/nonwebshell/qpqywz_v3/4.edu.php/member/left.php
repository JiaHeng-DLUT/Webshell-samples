<?php 
$M_login=$_SESSION["M_login"];
$M_id=$_SESSION["M_id"];

uplevel($M_id);
$sql="Select * from SL_member,SL_lv Where M_lv=L_id and M_id=".$M_id;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
		$M_pwd=$row["M_pwd"];
		$M_name=$row["M_name"];
		$M_code=$row["M_code"];
		$M_fen=$row["M_fen"];
		$M_pic=$row["M_pic"];
		$M_pic2=$row["M_pic"];
		$M_email=$row["M_email"];
		$M_qq=$row["M_QQ"];
		$M_add=$row["M_add"];
		$M_mobile=$row["M_mobile"];
		$M_lv=$row["M_lv"];
		$M_info=$row["M_info"];
		$M_vip=$row["M_vip"];
		$M_money=$row["M_money"];
		$L_title=lang($row["L_title"]);
		$L_discount=$row["L_discount"];
		$M_pic="member.jpg";
		if ($row["M_pic"]!=""){
		$M_pic=$row["M_pic"];
		}
		if ($M_name=="" || is_null($M_name)){
		$M_name=lang("未填写/l/null");
		}
		if ($M_code=="" || is_null($M_code)){
		$M_code=lang("未填写/l/null");
		}
		if ($M_qq=="" || is_null($M_qq)){
		$M_qq=lang("未填写/l/null");
		}
		if ($M_mobile=="" || is_null($M_mobile)){
		$M_mobile=lang("未填写/l/null");
		}
		if ($M_add=="" || is_null($M_add)){
		$M_add=lang("未填写/l/null");
		}

		if(substr($M_pic,0,4)!="http"){
		$M_pic=$C_dir."media/".$M_pic;
		}
?>