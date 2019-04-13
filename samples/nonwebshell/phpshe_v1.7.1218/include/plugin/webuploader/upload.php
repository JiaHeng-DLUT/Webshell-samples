<?php
//webuploader上传接口
include('../../../common.php');
if ($_FILES['file']['size']) {
	pe_lead('include/class/upload.class.php');
	if ($_REQUEST['uptype'] == 'avatar') {
		$upload = new upload($_FILES['file'], 'data/avatar/'.date('Y-m').'/');	
		echo json_encode(array('result'=>true, 'img'=>pe_thumb($upload->filehost, '_200', '_200', 'avatar'), 'val'=>$upload->filehost));
	}
	else {
		$upload = new upload($_FILES['file'], 'data/attachment/'.date('Y-m').'/');
		echo json_encode(array('result'=>true, 'bigimg'=>pe_thumb($upload->filehost), 'img'=>pe_thumb($upload->filehost), 'val'=>$upload->filehost));
	}
}
?>