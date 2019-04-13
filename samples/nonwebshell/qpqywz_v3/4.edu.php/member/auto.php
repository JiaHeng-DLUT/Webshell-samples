<?php 
$sql="select * from SL_orders where O_state=2 order by O_id desc";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {


$second=floor((strtotime(date('Y-m-d H:i:s'))-strtotime($row["O_time"]))%86400%60);


		if ($second>7*24*60*60){

		mysqli_query($conn,"update SL_orders set O_state=3 where O_id=".$row["O_id"]);
		}
	}
}
?>